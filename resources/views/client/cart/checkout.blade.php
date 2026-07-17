@extends('client.layouts.app')


@section('title','Thanh toán')



@section('content')


<div class="container py-4">


<h3 class="mb-4">

Thanh toán

</h3>



<div class="card">


<div class="card-body">


<form>


<div class="mb-3">

<label class="form-label">

Họ tên

</label>


<input type="text"
class="form-control">

</div>



<div class="mb-3">

<label class="form-label">

Số điện thoại

</label>


<input type="text"
class="form-control">

</div>



<div class="mb-3">

<label class="form-label">

Địa chỉ

</label>


<textarea class="form-control"></textarea>

</div>



<button class="btn btn-success">

Đặt hàng

</button>



</form>



</div>


</div>



</div>



@endsection