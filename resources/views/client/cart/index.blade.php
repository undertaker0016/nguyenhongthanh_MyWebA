@extends('client.layouts.app')


@section('title','Giỏ hàng')



@section('content')


<div class="container py-4">


<h3 class="mb-4">

Giỏ hàng

</h3>




<div class="alert alert-info">

Chưa có sản phẩm trong giỏ hàng

</div>




<a href="{{ route('home') }}"
class="btn btn-primary">

Tiếp tục mua hàng

</a>



</div>



@endsection