<form action="">
    @csrf
    <div class="table-responsive cart_info">

        <table class="table table-condensed">
            <thead>
                <tr class="cart_menu">
                    <td class="image">Hình ảnh</td>
                    <td class="description">Tên sản phẩm</td>
                    <td class="price">Giá sản phẩm</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Thành tiền</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>

                @php
                    $total = 0;
                    $cart = Session::get('cart');
                @endphp
                @if ($cart)
                @foreach (Session::get('cart') as $key => $cart)
                @php
                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                    $total += $subtotal;
                @endphp

                <tr>
                    <td class="cart_product">
                        <img src="{{ Avatar::create($cart['product_name'])->toBase64() }}" width="90"
                            alt="{{ $cart['product_name'] }}" />
                    </td>
                    <td class="cart_description">
                        <h4><a href=""></a></h4>
                        <p>{{ $cart['product_name'] }}</p>
                    </td>
                    <td class="cart_price">
                        <p>{{ number_format($cart['product_price'], 0, ',', '.') }}đ</p>
                    </td>
                    <td class="cart_quantity">
                        <div class="cart_quantity_button">
                            <form action="" method="POST">

                                <input class="num-order" type="number" min="1"
                                    name="num-order"
                                    value="{{ $cart['product_qty'] }}" data-id="{{ $cart['session_id'] }}">

                            </form>
                        </div>
                    </td>
                    <td class="cart_total">
                        <p class="cart_total_price">
                            {{ number_format($subtotal, 0, ',', '.') }}đ

                        </p>
                    </td>
                    <td class="cart_delete">
                        <button type="button" class="btn btn-default cart_quantity_delete"
                            data-id_product="{{ $cart['session_id'] }}" name="cart_quantity_delete">Xóa</button>
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td colspan='6' class="text-right">Tổng:</td>
                    <td><strong>{{ number_format($total, 0, ',', '.') }}đ</strong></td>

                </tr>
                <tr>
                    <td>
                        @if (Session('coupon'))
                            @foreach (Session('coupon') as $k => $v )
                                @if ($v['cordite'] == 1)
                                Mã giảm: {{ $v['number'] }} %
                                    <p>
                                        @php
                                            $totalCoupon = ($total*$v['number']) / 100;
                                            echo '<p>Tổng giảm:</p>'.number_format($totalCoupon, 0, ',', '.').'đ</p>';
                                        @endphp
                                    </p>
                                    <p>
                                        Tổng đã giảm: {{ number_format($total-$totalCoupon, 0, ',', '.') }}đ
                                    </p>
                                @elseif ($v['cordite'] == 2)
                                Mã giảm: {{ number_format($v['number'], 0, ',', '.') }}đ
                                <p>
                                    @php
                                        $totalCoupon = $total - $v['number']
                                    @endphp
                                </p>
                                <p>
                                    Tổng đã giảm: {{ number_format($totalCoupon, 0, ',', '.') }}đ
                                </p>
                                @endif
                            @endforeach
                        @endif
                    </td>
                </tr>
                @else
                    <tr>
                        <td>
                            Không có sản phẩm nào trong giỏ hàng
                        </td>
                    </tr>
                @endif

            </tbody>


        </table>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
    integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.cart_quantity_delete').click(function(e) {
            e.preventDefault();
            let id = $(this).data('id_product');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: `https://quocmanh.com/Laravel-8/demo/product/delete-product/${id}`,
                method: 'DELETE',
                data: {
                    session_id: id,
                    _token: _token
                },
                success: function(data) {
                    load_data();
                    Swal.fire({
                        title: 'Success',
                        text: 'Xóa sản phẩm vào giỏ hàng thành công',
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
        $('.num-order').change(function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let qty = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url: "{{ route('demo.update_cart') }}",
                method: 'POST',
                data: {
                    id: id,
                    qty: qty,
                },
                success: function(data) {
                    load_data();
                }

            });
        });
    });
</script>
