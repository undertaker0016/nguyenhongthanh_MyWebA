<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
   //chỉ định tên bảng trong database
   //có thể bỏ qua jhai báo $table nếu tên bảng trùng với tên model (số nhiều)
   protected $table = 'products';
   //chỉ định khóa chính của bảng
   //có thể bỏ qua khai báo $primaryKey nếu tên khóa chính là 'id'
    protected $primaryKey = 'id';
    //các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
        'productname',
        'slug',
        'price',
        'pricediscount',
        'image',
        'description',
        'status',
        'cateid',
        'brandid',
    ];
    //cấu hình quan hệ với bảng categories
    public function category() {
        //products.cateid => categories.cateid
        return $this->belongsTo(Category::class, 'cateid', 'cateid');
    }
    //cau hình quan hệ với bảng brands
    public function brand() {
        //products.brandid => brands.id
        return $this->belongsTo(Brand::class, 'brandid', 'id');
    }

    //cấu hình quan hệ với bảng product_images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
}