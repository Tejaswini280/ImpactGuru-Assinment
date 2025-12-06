<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('amount');
        $recentCustomers = Customer::latest()->take(5)->get();

        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        return view('dashboard', compact(
            'totalCustomers',
            'totalOrders',
            'totalRevenue',
            'recentCustomers',
            'pendingOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }
}
