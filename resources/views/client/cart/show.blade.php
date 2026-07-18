@extends('client.layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    @php

        $cart = Session::get('cart', []);

        $total = 0;

        $totalQuantity = 0;

    @endphp


    <div class="container py-4">


        <h3 class="mb-4">
            Thanh toán
        </h3>



        @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
        @endif



        @if (session('error'))
            <div class="alert alert-danger">

                {{ session('error') }}

            </div>
        @endif



        <form action="{{ route('cart.checkout') }}" method="POST">

            @csrf


            <div class="row">


                {{-- Thông tin khách hàng --}}

                <div class="col-md-5">


                    <div class="card shadow-sm">


                        <div class="card-header">

                            <strong>
                                Thông tin khách hàng
                            </strong>

                        </div>



                        <div class="card-body">


                            <div class="mb-3">

                                <label class="form-label">
                                    Họ và tên
                                </label>

                                <input type="text" name="fullname" class="form-control" required>

                            </div>



                            <div class="mb-3">

                                <label class="form-label">
                                    Số điện thoại
                                </label>

                                <input type="text" name="phone" class="form-control" required>

                            </div>



                            <div class="mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" name="email" class="form-control">

                            </div>



                            <div class="mb-3">

                                <label class="form-label">
                                    Địa chỉ
                                </label>

                                <textarea name="address" class="form-control" required></textarea>

                            </div>



                            <div class="mb-3">

                                <label class="form-label">
                                    Ghi chú
                                </label>

                                <textarea name="note" class="form-control"></textarea>

                            </div>


                        </div>


                    </div>


                </div>




                {{-- Danh sách sản phẩm --}}

                <div class="col-md-7">


                    <div class="card shadow-sm">


                        <div class="card-header">

                            <strong>
                                Đơn hàng của bạn
                            </strong>

                        </div>



                        <div class="card-body">


                            @if (count($cart) > 0)


                                <table class="table table-bordered align-middle">


                                    <thead class="table-dark">

                                        <tr>

                                            <th>
                                                STT
                                            </th>

                                            <th>
                                                Ảnh
                                            </th>

                                            <th>
                                                Tên
                                            </th>

                                            <th>
                                                Giá
                                            </th>

                                            <th>
                                                SL
                                            </th>

                                            <th>
                                                Thành tiền
                                            </th>

                                            <th>
                                                Xóa
                                            </th>

                                        </tr>

                                    </thead>



                                    <tbody>


                                        @foreach ($cart as $item)
                                            @php

                                                $subtotal = $item['price'] * $item['quantity'];

                                                $total += $subtotal;

                                                $totalQuantity += $item['quantity'];

                                            @endphp



                                            <tr>


                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>



                                                <td>

                                                    <img src="{{ asset('storage/products/' . $item['image']) }}"
                                                        width="70">

                                                </td>



                                                <td>

                                                    {{ $item['productname'] }}

                                                </td>



                                                <td>

                                                    {{ number_format($item['price']) }} đ

                                                </td>



                                                <td>

                                                    {{ $item['quantity'] }}

                                                </td>



                                                <td class="text-danger fw-bold">

                                                    {{ number_format($subtotal) }} đ

                                                </td>



                                                <td>


                                                    <button type="button" class="btn btn-danger btn-remove-cart"
                                                        data-url="{{ route('cart.remove', $item['productid']) }}">

                                                        Xóa

                                                    </button>


                                                </td>



                                            </tr>
                                        @endforeach



                                    </tbody>



                                    <tfoot>


                                        <tr>

                                            <th colspan="4" class="text-end">

                                                Tổng số lượng

                                            </th>


                                            <th>

                                                <span id="totalQuantity">

                                                    {{ $totalQuantity }}

                                                </span>

                                            </th>

                                            <th colspan="2"></th>

                                        </tr>



                                        <tr>

                                            <th colspan="5" class="text-end">

                                                Tổng tiền

                                            </th>


                                            <th class="text-danger">

                                                <span id="total">

                                                    {{ number_format($total) }} đ

                                                </span>

                                            </th>


                                            <th></th>


                                        </tr>



                                    </tfoot>


                                </table>
                            @else
                                <div class="alert alert-warning">

                                    Giỏ hàng đang trống.

                                </div>


                            @endif



                        </div>


                    </div>



                    <div class="text-end mt-3">


                        <a href="{{ route('home') }}" class="btn btn-secondary">

                            Quay lại mua hàng

                        </a>



                        <button type="submit" class="btn btn-primary">
                            Xác nhận đặt hàng
                        </button>


                    </div>



                </div>


            </div>


        </form>


    </div>


@endsection
