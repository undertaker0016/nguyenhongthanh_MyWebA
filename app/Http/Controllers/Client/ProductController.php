<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('client.product.index');
    }

    public function show($slug)
    {
        $product = Product::select(
            'id',
            'cateid',
            'brandid',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'description'
        )
            ->with([
                'category:cateid,catename',
                'brand:id,brandname',
                'images:id,product_id,image'
            ])
            ->where('slug', $slug)
            ->firstOrFail();


        // Sản phẩm liên quan cùng danh mục

        $relatedProducts = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )
            ->where('cateid', $product->cateid)
            ->where('id', '<>', $product->id)
            ->take(4)
            ->get();


        return view(
            'client.products.show',
            compact(
                'product',
                'relatedProducts'
            )
        );
    }

    public function category($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'categories.catename'
        )
            ->join('categories', 
            'products.cateid',
             'categories.cateid')
            ->where(
            'categories.slug', $slug)
            ->where(
            'products.status', 1)
            ->paginate($limit);

        return view('client.products.category', compact('products'));
    }

    public function brand($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'brands.brandname'
        )
            ->join('brands', 'products.brandid', 'brands.id')
            ->where('brands.slug', $slug)
            ->where('products.status', 1)
            ->paginate($limit);

        return view('client.products.brand', compact('products'));
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $products = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )
            ->where('status', 1);

        // Tìm theo tên sản phẩm
        if ($keyword) {

            $products->where(
                'productname',
                'LIKE',
                '%' . $keyword . '%'
            );
        }


        // Lọc giá từ
        if ($request->price_from) {

            $products->where(
                'price',
                '>=',
                $request->price_from
            );
        }


        // Lọc giá đến
        if ($request->price_to) {

            $products->where(
                'price',
                '<=',
                $request->price_to
            );
        }


        // Sắp xếp
        if ($request->sort == 'name') {

            $products->orderBy(
                'productname',
                'asc'
            );
        } elseif ($request->sort == 'price') {

            $products->orderBy(
                'price',
                'asc'
            );
        } else {

            $products->orderByDesc(
                'created_at'
            );
        }


        $products = $products
            ->paginate(12)
            ->withQueryString();


        return view(
            'client.products.search',
            compact(
                'products',
                'keyword'
            )
        );
    }
}
