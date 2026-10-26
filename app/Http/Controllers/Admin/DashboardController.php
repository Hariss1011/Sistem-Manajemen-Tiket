<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'events' => Event::count(),
            'upcoming' => Event::upcoming()->count(),
            'orders' => Order::count(),
            'tickets' => (int) DetailOrder::sum('jumlah'),
            'revenue' => (float) Order::sum('total_harga'),
        ];

        $recentOrders = Order::with(['user', 'event'])->latest('order_date')->limit(6)->get();

        $topEvents = DB::table('detail_orders')
            ->join('tikets', 'tikets.id', '=', 'detail_orders.tiket_id')
            ->join('events', 'events.id', '=', 'tikets.event_id')
            ->whereNull('events.deleted_at')
            ->groupBy('events.id', 'events.judul')
            ->orderByDesc('terjual')
            ->limit(5)
            ->get([
                'events.id',
                'events.judul',
                DB::raw('SUM(detail_orders.jumlah) as terjual'),
                DB::raw('SUM(detail_orders.subtotal_harga) as pendapatan'),
            ]);

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topEvents'));
    }
}
