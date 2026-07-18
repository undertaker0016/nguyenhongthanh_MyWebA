<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{


    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $id)
    {

        $product = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )
            ->findOrFail($id);


        // lấy cart từ session
        $cart = session()->get('cart', []);



        // nếu sản phẩm đã có trong giỏ
        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;
        } else {

            $cart[$id] = [

                'productid' => $product->id,

                'productname' => $product->productname,

                'slug' => $product->slug,

                'image' => $product->image,

                'price' => $product->pricediscount ?: $product->price,

                'quantity' => 1

            ];
        }



        // lưu lại session
        session()->put('cart', $cart);



        return response()->json([

            'status' => true,

            'message' => 'Đã thêm sản phẩm vào giỏ hàng.',

            'cartCount' => collect($cart)->sum('quantity')

        ]);
    }





    // Hiển thị giỏ hàng
    public function show()
    {

        return view('client.cart.show');
    }





    // Xóa sản phẩm khỏi giỏ hàng
    public function removeCart($id)
    {

        $cart = session()->get('cart', []);



        if (isset($cart[$id])) {

            unset($cart[$id]);
        }



        if (empty($cart)) {

            session()->forget('cart');
        } else {

            session()->put('cart', $cart);
        }



        $total = collect($cart)
            ->sum(fn($item) => $item['price'] * $item['quantity']);



        return response()->json([

            'status' => true,

            'message' => 'Đã xóa sản phẩm.',

            'cartCount' => collect($cart)->sum('quantity'),

            'total' => $total,

            'isEmpty' => empty($cart)

        ]);
    }

    // Xác nhận đặt hàng
    public function checkout(Request $request)
    {

        // Validate
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'nullable|email'
        ]);


        // Lấy giỏ hàng
        $cart = session()->get('cart', []);



        // Kiểm tra giỏ hàng trống
        if (empty($cart)) {
            return back()->with(
                'error',
                'Giỏ hàng đang trống.'
            );
        }



        DB::beginTransaction();


        try {


            // Tìm khách hàng theo số điện thoại

            $customer = Customer::where(
                'phone',
                $request->phone
            )->first();



            // Nếu chưa có thì tạo mới

            if (!$customer) {

                $customer = Customer::create([

                    'fullname' => $request->fullname,

                    'email' => $request->email,

                    'phone' => $request->phone,

                    'address' => $request->address

                ]);
            }



            // Tính tổng tiền

            $total = collect($cart)->sum(
                fn($item) =>
                $item['price'] * $item['quantity']
            );



            // Tạo đơn hàng

            $order = Order::create([

                'customer_id' => $customer->id,

                'order_code' => 'DH' . time(),

                'total_amount' => $total,

                'status' => 'pending',

                'note' => $request->note

            ]);




            // Lưu chi tiết đơn hàng

            foreach ($cart as $item) {

                OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $item['productid'],

                    'quantity' => $item['quantity'],

                    'price' => $item['price']

                ]);
            }



            // Lưu thành công

            DB::commit();



            // Xóa giỏ hàng

            session()->forget('cart');



            return back()->with(
                'success',
                'Đặt hàng thành công.'
            );
        } catch (\Exception $e) {


            DB::rollBack();


            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}
