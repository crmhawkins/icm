<?php

namespace App\Http\Controllers\Tpv;

use App\Http\Controllers\Controller;
use App\Models\Tpv\Category;
use App\Models\Tpv\Order;
use App\Models\Tpv\OrderItem;
use App\Models\Tpv\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TpvController extends Controller
{

    public function categorias() {
        return Category::with('products')->where('inactive', 0)->get();
    }

    public function productos($categoryId) {
        return Product::where('category_id', $categoryId)->where('inactive', 0)->get();
    }

    public function orders(){
        return Order::with('items.product')->where('status', 'open')->get();

    }

    public function store(Request $request)
    {
        $order = Order::create(['numero' => 0, 'status' => 'open', 'total' => 0]);


        return response()->json($order, 201);
    }

    public function addItem(Request $request, Order $order)
    {
        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        $order->update(['total' => $order->items()->sum('price')]);
        return response()->json($item, 201);
    }

    public function close(Order $order)
    {
        $order->update(['status' => 'closed']);
        return response()->json(['message' => 'Order closed'], 200);
    }
}
