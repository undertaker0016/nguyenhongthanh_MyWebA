{{-- thừa kế layout admin/view admin.blade.php --}}
{{-- resource/views/admin/layouts/dashboard.blade.php --}}
@extends('admin.layouts.admin')
{{-- gán nội dung cho section title --}}
{{--(tương tự với @yield('title') trong layout) --}}
@section('title', 'Xin chào')
{{-- gán nội dung cho section content --}}
{{--(tương tự với @yield('content')  trong layout) --}}
@section('content')
      <h1>My Dashboard</h1>
@endsection