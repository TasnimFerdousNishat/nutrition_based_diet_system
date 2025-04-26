<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\FoodItem;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function showMenu() {
        $foods = FoodItem::all();
        return view('menu', compact('foods'));
    }

    public function placeOrder(Request $request) {
        $data = $request->validate([
            'c_id'=>'nullable',
            'name' => 'required',
            'phone' => 'required',
            'payment_method' => 'required',
            'cart' => 'required|array',
        ]);

        $total = 0;
        $foodIds = collect($data['cart'])->pluck('id');
        $foods = FoodItem::whereIn('id', $foodIds)->get()->keyBy('id');
    
        foreach ($data['cart'] as $item) {
            if (!isset($foods[$item['id']])) {
                return response()->json(['error' => 'Food item not found.'], 404);
            }
            $food = $foods[$item['id']];
            $total += $food->price * $item['quantity'];
        }
    
        $order = Order::create([
            'customer_id'=> Auth::id() ?? $data['c_id'],
            'customer_name' => $data['name'],
            'customer_phone' => $data['phone'],
            'payment_method' => $data['payment_method'],
            'total_price' => $total,
            'status' => 'pending',
        ]);
    
        foreach ($data['cart'] as $item) {
            $food = $foods[$item['id']];
            OrderItem::create([
                'order_id' => $order->id,
                'food_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $food->price
            ]);
        }

        return response()->json(['message' => 'Order placed successfully!']);
    }

    public function pendingOrders() {
        $orders = Order::where('status', 'pending')->with('orderItems.foodItem')->get();
        return view('admin.pending_orders', compact('orders'));
    }

    public function approvedOrders() {
        $orders = Order::where('status', 'approved')->with('orderItems.foodItem')->get();
        return view('admin.approved_orders', compact('orders'));
    }

    public function approveOrder($id) {
        $order = Order::findOrFail($id);
        $order->status = 'approved';
        $order->save();

        return response()->json(['message' => 'Order approved successfully.']);
    }

    public function dailySales() {
        $today = Carbon::today();
        $total = Order::whereDate('created_at', $today)->sum('total_price');
        return view('admin.sales', compact('total'));
    }

    public function userApprovedOrders() {
        // Fetch approved orders for the logged-in user based on their customer_id (using Auth::id())
        $orders = Order::with('orderItems.foodItem')
            ->where('status', 'approved')
            ->where('customer_id', auth()->user()->id)  // Change to use customer_id
            ->get();

        return view('user_orders', compact('orders'));
    }

    public function markAsDelivered($id) {
        $order = Order::findOrFail($id);
        $order->is_delivered = true;
        $order->save();

        return response()->json(['message' => 'Order marked as delivered.']);
    }
}
