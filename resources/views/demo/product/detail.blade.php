@extends('layouts.shop')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
            @endif
            <h1>Shop</h1>
            <div class="list-product mt-3">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                        <form action="{{ route('demo.product.save') }}" method="post">
                            @csrf
                            <div class="product-item border py-2">
                                <div class="product-thumb text-center">
                                    <a href="">
                                        <img class="img-fluid t" src="{{ Avatar::create($product->product_name)->toBase64() }}" alt="">
                                    </a>
                                </div>
                                <div class="product-info p-2 text-center">
                                    <a class="product-title" href="">{{ $product->product_name }}</a>
                                    <div class="price-box">
                                        <span class="current-price text-danger">{{ number_format($product->product_price_new,0,'','.') }} đ</span>
                                        <span class="old-price text-muted">{{ number_format($product->product_price_old,0,'','.') }} đ</span>
                                    </div> <br>
                                    <label for="">Số lượng</label> <br>
                                    <input type="number" name="qty" id="" min='1' value='1'> <br>
                                    <input type="hidden" name="product_id" value='{{ $product->product_id }}'> <br>
                                    <button type="submit" class="btn cart">
                                        Thêm giỏ hàng
                                    </button> <br>
                                    <a href="{{ route('demo.product.detail',$product->product_id)}}" class="btn btn-outline-danger btn-sm mt-3" class="add-to-cart">Detail</a> <br>
                                    <a href="{{ route('demo.cart.add',$product->product_id) }}" class="btn btn-outline-danger btn-sm mt-3" class="add-to-cart">Đặt Mua</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
