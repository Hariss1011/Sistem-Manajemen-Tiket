<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Order;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    private function buyer(): User
    {
        return User::where('email', 'user@gmail.com')->firstOrFail();
    }

    private function upcomingEvent(): Event
    {
        return Event::upcoming()->with('tikets')->where('judul', 'Workshop UI Design dengan Figma')->firstOrFail();
    }

    public function test_tamu_diarahkan_ke_login_saat_membuka_riwayat_pesanan(): void
    {
        $this->get('/orders')->assertRedirect('/login');
    }

    public function test_user_tidak_bisa_melihat_pesanan_milik_orang_lain(): void
    {
        $order = Order::firstOrFail();
        $lain = User::factory()->create();

        $this->actingAs($lain)->get(route('orders.show', $order))->assertForbidden();
        $this->actingAs($this->buyer())->get(route('orders.show', $order))->assertOk();
    }

    public function test_pembelian_berhasil_menghitung_total_di_server_dan_mengurangi_stok(): void
    {
        $event = $this->upcomingEvent();
        $tiket = $event->tikets->first();
        $stokAwal = $tiket->stok;

        $this->actingAs($this->buyer())
            ->postJson(route('orders.store'), [
                'event_id' => $event->id,
                'items' => [['tiket_id' => $tiket->id, 'jumlah' => 2]],
            ])
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->assertSame($stokAwal - 2, $tiket->fresh()->stok);
        $this->assertEquals($tiket->harga * 2, Order::latest('id')->first()->total_harga);
    }

    public function test_baris_ganda_dengan_tiket_sama_tidak_bisa_melewati_stok(): void
    {
        $event = $this->upcomingEvent();
        $tiket = $event->tikets->first();
        $tiket->update(['stok' => 5]);

        $this->actingAs($this->buyer())
            ->postJson(route('orders.store'), [
                'event_id' => $event->id,
                'items' => [
                    ['tiket_id' => $tiket->id, 'jumlah' => 4],
                    ['tiket_id' => $tiket->id, 'jumlah' => 4],
                ],
            ])
            ->assertStatus(422);

        $this->assertSame(5, $tiket->fresh()->stok);
    }

    public function test_tiket_dari_event_lain_ditolak(): void
    {
        $event = $this->upcomingEvent();
        $tiketLain = Tiket::where('event_id', '!=', $event->id)->firstOrFail();

        $this->actingAs($this->buyer())
            ->postJson(route('orders.store'), [
                'event_id' => $event->id,
                'items' => [['tiket_id' => $tiketLain->id, 'jumlah' => 1]],
            ])
            ->assertStatus(422);
    }

    public function test_event_yang_sudah_lewat_tidak_bisa_dibeli(): void
    {
        $event = Event::where('judul', 'Konser Reuni Band Kampus')->with('tikets')->firstOrFail();

        $this->actingAs($this->buyer())
            ->postJson(route('orders.store'), [
                'event_id' => $event->id,
                'items' => [['tiket_id' => $event->tikets->first()->id, 'jumlah' => 1]],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('event_id');
    }

    public function test_user_biasa_mendapat_403_di_area_admin_dan_tidak_ter_logout(): void
    {
        $this->actingAs($this->buyer())->get('/admin')->assertForbidden();
        $this->assertAuthenticated();
    }

    public function test_admin_bisa_membuka_dashboard(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_pesanan_tetap_terbaca_setelah_event_dihapus_admin(): void
    {
        $order = Order::with('event')->firstOrFail();
        $order->event->delete(); // soft delete

        $this->actingAs($this->buyer())
            ->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee($order->event->judul);
    }
}
