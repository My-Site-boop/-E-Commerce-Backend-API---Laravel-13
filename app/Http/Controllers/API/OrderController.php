<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return ApiResponse::success(
            'Orders List',
            OrderResource::collection($orders)
        );
    }

    public function store(OrderRequest $request)
    {
        DB::beginTransaction();

        try {

            $total = 0;

            $order = Order::create([

                'user_id' => auth()->id(),

                'total_amount' => 0,

                'status' => 'pending'
            ]);

            foreach ($request->items as $item) {

                $product = Product::findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                         
                     DB::rollBack();
                    return ApiResponse::error(
                        'Insufficient stock for ' . $product->name,
                        400
                    );
                }

                $subtotal = $product->price * $item['quantity'];

                $total += $subtotal;

                OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $product->id,

                    'quantity' => $item['quantity'],

                    'price' => $product->price,

                    'subtotal' => $subtotal
                ]);

                $product->decrement(
                    'stock_quantity',
                    $item['quantity']
                );
            }

            $order->update([
                'total_amount' => $total
            ]);

            DB::commit();

            $order->load(['user', 'items.product']);

            return ApiResponse::success(
                'Order Placed Successfully',
                new OrderResource($order)
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);

        return ApiResponse::success(
            'Order Details',
            new OrderResource($order)
        );
    }
}