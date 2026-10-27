<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class HistoriesController extends Controller
{
    /**
     * Menampilkan riwayat pembelian dengan pagination.
     */
    public function index()
    {
        $histories = Order::query()
            ->with([
                'user',
                'event',
            ])
            ->orderByDesc('order_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.history.index', compact('histories'));
    }

    /**
     * Menampilkan detail transaksi beserta tiket yang dibeli.
     */
    public function show(string $id)
    {
        $order = Order::query()
            ->with([
                'user',
                'event.lokasi',
                'detailOrders.tiket.tipeTiket',
            ])
            ->findOrFail($id);

        return view('admin.history.show', compact('order'));
    }
}
