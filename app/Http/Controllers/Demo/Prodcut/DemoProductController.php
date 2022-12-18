<?php

namespace App\Http\Controllers\Demo\Prodcut;

use App\Http\Controllers\Controller;
use App\Models\Demo\Product\DemoProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DemoProductController extends Controller
{
    public function show()
    {
        $products = DemoProduct::paginate(8);
        return view('demo.product.show', compact('products'));
    }
    public function detail($id)
    {
        $product = DemoProduct::where('product_id', $id)->first();
        return view('demo.product.detail', compact('product'));
    }

    public function saveProduct(Request $request)
    {
        $productId = $request->product_id;
        $qty = $request->qty;

        $products = DemoProduct::where('product_id', $productId)->get();
        return view('demo.cart.show', compact('products'));

    }

    public function addCartAjax(Request $request)
    {
        session_start();
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        // dd($data);
        if ($cart) {
            $is_available = 0;
            foreach ($cart as $val) {
                if ($val['product_id'] == $data['cart_product_id']) {
                    $is_available++;
                }
            }
            if ($is_available == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart', $cart);
        }

        Session::save();

        return response()->json([
            'success' => true,
        ]);

    }

    public function deleteProduct($session_id)
    {
        $cart = Session::get('cart');
        if ($cart) {
            foreach ($cart as $k => $v) {
                if ($v['session_id'] == $session_id) {
                    unset($cart[$k]);
                }
            }
            Session::put('cart', $cart);
            return response()->json([
                'success' => true,
            ]);
        }
    }

    public function updateCart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart) {
            foreach ($cart as $key => $value) {
                if ($value['session_id'] == $data['id']) {
                    $cart[$key]['product_qty'] = $data['qty'];
                }
            }
            Session::put('cart', $cart);
            return response()->json([
                'success' => true,
                'message' => 'Update success',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update fail',
            ]);
        }
    }

    public function deleteCart()
    {
        $cart = Session::get('cart');
        if($cart){
            Session::forget('cart');
            Session::forget('coupon');
            return response()->json([
                'success' => true,
                'message' => 'Delete all product success',
            ]);
        }
    }

}
