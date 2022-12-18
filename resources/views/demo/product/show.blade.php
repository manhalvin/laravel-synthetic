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
                        @foreach ($products as $product)
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <form action="">
                                    @csrf
                                    <input type="hidden" class='cart_product_id_{{ $product->product_id }}'
                                        value="{{ $product->product_id }}">
                                    <input type="hidden" class='cart_product_name_{{ $product->product_id }}'
                                        value="{{ $product->product_name }}">
                                    <input type="hidden" class='cart_product_image_{{ $product->product_id }}'
                                        value='{{ Avatar::create($product->product_name)->toBase64() }}'>
                                    <input type="hidden" class='cart_product_price_{{ $product->product_id }}'
                                        value='{{ $product->product_price_new }}'>
                                    <input type="hidden" class='cart_product_qty_{{ $product->product_id }}'
                                        value='1'>
                                    <div class="product-item border py-2">
                                        <div class="product-thumb text-center">
                                            <a href="">
                                                <img class="img-fluid t"
                                                    src="{{ Avatar::create($product->product_name)->toBase64() }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="product-info p-2 text-center">
                                            <a class="product-title" href="">{{ $product->product_name }}</a>
                                            <div class="price-box">
                                                <span
                                                    class="current-price text-danger">{{ number_format($product->product_price_new, 0, '', '.') }}
                                                    đ</span>
                                                <span
                                                    class="old-price text-muted">{{ number_format($product->product_price_old, 0, '', '.') }}
                                                    đ</span>
                                            </div>
                                            <a href="{{ route('demo.product.detail', $product->product_id) }}"
                                                class="btn btn-outline-danger btn-sm mt-3" class="">Detail</a>
                                            <br>
                                            <button type="button" class="btn btn-default add-to-cart"
                                                data-id_product="{{ $product->product_id }}" name="add-to-cart">Thêm giỏ
                                                hàng</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                        <div class="col-12">
                            {{-- {{$products->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
        integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-to-cart').click(function(e) {
                e.preventDefault();
                let id = $(this).data('id_product');
                let cart_product_id = $('.cart_product_id_' + id).val();
                let cart_product_name = $('.cart_product_name_' + id).val();
                let cart_product_image = $('.cart_product_image_' + id).val();
                let cart_product_price = $('.cart_product_price_' + id).val();
                let cart_product_qty = $('.cart_product_qty_' + id).val();
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ route('add-cart-ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        _token: _token
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Thêm sản phẩm vào giỏ hàng thành công',
                            icon: 'success',
                            confirmBbuttonText: 'Cool'
                        })
                    }

                });
            });
        });
    </script>
   
@endsection
