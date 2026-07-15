<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SoftDeletes;
   //chỉ định tên bảng trong database
   //có thể bỏ qua jhai báo $table nếu tên bảng trùng với tên model (số nhiều)
   protected $table = 'categories';
   //chỉ định khóa chính của bảng
   //có thể bỏ qua khai báo $primaryKey nếu tên khóa chính là 'id'
    protected $primaryKey = 'cateid';
    //các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
        'catename', 
        'slug',
        'description',
        'image',
        'status',
    ];


}
