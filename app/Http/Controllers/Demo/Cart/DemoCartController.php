<?php

namespace App\Http\Controllers\Demo\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\Models\Demo\Product\DemoProduct;
use Gloudemans\Shoppingcart\Facades\Cart;


class DemoCartController extends Controller
{
    public function show()
    {
        return view('demo.cart.show');
    }

    public function ajaxCart()
    {
        return view('demo.cart.ajax');
    }
    public function add($id,Request $request)
    {
        $product = DemoProduct::where('product_id',$id)->first();
        if($product){
            Cart::add([
                'id' => $product->product_id,
                'name' => $product->product_name,
                'qty' => 1,
                'price' => $product->product_price_new,
                'options' => ['image' =>  $product->product_image],
            ]);
            return redirect()->route('demo.cart.show')->with('status','Thêm sản phẩm vào giỏ hàng thành công');
        }else{
            return redirect()->back()->with('error','Sản phẩm không tồn tại !');
        }
    }

    public function remove($rowId){
        Cart::remove($rowId);
        return redirect()->route('demo.cart.show')->with('status','Xóa sản phẩm thành công');
    }

    public function destroy(){
        Cart::destroy();
        return redirect()->route('demo.cart.show')->with('status','Xóa giỏ hàng thành công');
    }

    public function update(Request $request){
        $qty = $request->qty;
        foreach ($qty as $key => $value) {
            Cart::update($key, $value);
        }
        // return $request->all();
        return response()->json(['success'=>'true'], 200);

    }

    public function checkoutCoupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('code', $data['coupon'])->first();
        if($coupon){
            $countCoupon = $coupon->count();
            if($countCoupon>0){
                $couponSession = Session::get('coupon');
                if($couponSession == true){
                    $is_available = 0;
                    if($is_available == 0){
                        $cou[]= array(
                            'code' => $coupon->code,
                            'cordite' => $coupon->cordite,
                            'number' => $coupon->number
                        );
                        Session::put('coupon', $cou);
                    }
                }else{
                    $cou[] = array(
                        'code' => $coupon->code,
                        'cordite' => $coupon->cordite,
                        'number' => $coupon->number
                    );
                    Session::put('coupon', $cou);
                }
                Session::save();
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm mã giảm giá thành công',
                ]);
            }
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Nhập mã giảm giá ko đúng',
            ]);
        }
    }


}
