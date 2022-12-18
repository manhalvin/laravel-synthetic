@extends('layouts.shop')
@php
    use Gloudemans\Shoppingcart\Facades\Cart;

@endphp
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('demo.cart.update') }}" method="post">
                    @csrf
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Giỏ hàng</h1>
                    <p>

                    </p>
                    <div class='category-product-list'>

                    </div>
                    {{-- <input class="btn btn-primary changeQuantity" type="submit" value="Cập nhật giỏ hàng"> --}}
                    <button type="button" class="btn btn-primary delete_cart">Xóa giỏ hàng</button>


                </form> <br>
            </div>
        </div>
        <form>
            @csrf
            <input type="text" name="coupon" id="" class="fom-control" placeholder="Nhập mã giảm giá"> <br>
            <br>
            <input type="submit" value="Tính giá giảm giá" name='check_coupon' class='btn btn-success check_coupon'> <br>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
        integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const endpoint = "https://quocmanh.com/Laravel-8/demo/cart/ajax";
        load_data();

        function load_data() {
            $.get(endpoint, function(res) {
                $('.category-product-list').html(res);
            });
        }

        $(document).ready(function() {

            $('.changeQuantity').click(function(e) {
                e.preventDefault();

                let quantity = $(this).find('.qty-input').val();
                let cards = $('.qty-input').serializeArray();

                let data = {
                    '_token': $('input[name=_token]').val(),
                };

                $(cards).each(function(index, obj) {
                    data[obj.name] = obj.value;
                    //  obj = [{name: 'qty[cc7c73b98c443d0a0aa654e20cb2843a]', value: '2'},
                    // {name: 'qty[812e6636bb7f4afb83059d67ae892308]', value: '4']
                });


                $.ajax({
                    url: 'https://quocmanh.com/Laravel-8/demo/cart/update',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        load_data();
                    }
                });
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete_cart').click(function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    url: "{{ route('demo.delete_cart') }}",
                    method: 'DELETE',
                    success: function(data) {
                        load_data();
                        Swal.fire({
                            title: 'Success',
                            text: 'Xóa giỏ hàng thành công',
                            icon: 'success',
                            confirmBbuttonText: 'Cool'
                        })
                    }

                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.check_coupon').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let coupon = $('input[name="coupon"]').val();
                $.ajax({
                    url: "{{ route('demo.cart.checkout_coupon') }}",
                    method: 'POST',
                    data: {
                        coupon: coupon
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
                            confirmBbuttonText: 'Cool'
                        })
                        load_data();
                    },
                    error: function(data){
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmBbuttonText: 'Cool'
                        })
                        load_data();
                    }

                });
            });
        });
    </script>
@endsection
