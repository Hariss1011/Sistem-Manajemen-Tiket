<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dan ringkasan penjualan tiket.
     */
    public function index()
    {
        // Ringkasan statistik berdasarkan data yang tersimpan.
        $stats = [
            'events' => Event::count(),

            'upcoming' => Event::upcoming()->count(),

            'orders' => Order::count(),

            'tickets' => (int) DetailOrder::sum('jumlah'),

            'revenue' => (float) Order::sum('total_harga'),
        ];

        // Enam pesanan terakhir beserta pembeli dan event terkait.
        $recentOrders = Order::query()
            ->with(['user', 'event'])
            ->orderByDesc('order_date')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        // Lima event terlaris berdasarkan jumlah tiket dalam transaksi.
        $topEvents = DB::table('detail_orders')
            ->join('tikets', 'tikets.id', '=', 'detail_orders.tiket_id')
            ->join('events', 'events.id', '=', 'tikets.event_id')
            ->whereNull('events.deleted_at')
            ->select([
                'events.id',
                'events.judul',
            ])
            ->selectRaw('SUM(detail_orders.jumlah) AS terjual')
            ->selectRaw('SUM(detail_orders.subtotal_harga) AS pendapatan')
            ->groupBy('events.id', 'events.judul')
            ->orderByDesc('terjual')
            ->orderBy('events.judul')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topEvents'
        ));
    }
}
