@extends('client.layouts.app')

@section('title', 'Tìm kiếm sản phẩm')

@section('content')

    <div class="container py-4">


        <h3 class="mb-4">
            Tìm kiếm: "{{ $keyword }}"
        </h3>


        <form method="GET" action="{{ route('products.search') }}" class="row g-3 mb-4">


            <div class="col-md-3">

                <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}"
                    placeholder="Tên sản phẩm">

            </div>


            <div class="col-md-2">

                <input type="number" name="price_from" class="form-control" value="{{ request('price_from') }}"
                    placeholder="Giá từ">

            </div>


            <div class="col-md-2">

                <input type="number" name="price_to" class="form-control" value="{{ request('price_to') }}"
                    placeholder="Giá đến">

            </div>


            <div class="col-md-3">

                <select name="sort" class="form-control">


                    <option value="">
                        Sắp xếp
                    </option>


                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                        Theo tên
                    </option>


                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>
                        Theo giá
                    </option>


                </select>

            </div>


            <div class="col-md-2">

                <button class="btn btn-primary w-100">
                    Lọc
                </button>

            </div>


        </form>



        @if ($products->count())


            <div class="row g-4">


                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">

                        <x-client.product :product="$product" />

                    </div>
                @endforeach


            </div>


            <div class="mt-4 d-flex justify-content-center">

                {{ $products->links() }}

            </div>
        @else
            <div class="alert alert-warning">

                Không tìm thấy sản phẩm phù hợp.

            </div>


        @endif


    </div>

@endsection
