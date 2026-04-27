<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil user dengan total qty barang yang sudah dibayar (paid)
        $users = User::where('role', 'user')
            ->leftJoin('orders', function($join) {
                $join->on('users.id', '=', 'orders.user_id')
                     ->where('orders.status_payment', '=', 'paid');
            })
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                DB::raw('IFNULL(SUM(order_items.qty), 0) as total_checkout')
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->orderBy('total_checkout', 'desc')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}