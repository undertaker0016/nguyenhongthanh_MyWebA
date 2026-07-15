<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
   //chỉ định tên bảng trong database
   //có thể bỏ qua jhai báo $table nếu tên bảng trùng với tên model (số nhiều)
   protected $table = 'brands';
   //chỉ định khóa chính của bảng
   //có thể bỏ qua khai báo $primaryKey nếu tên khóa chính là 'id'
    protected $primaryKey = 'id';
    //các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
    'brandname',
    'slug',
    'image',
    'status',
    'sort_order',
    'description',
];


}
