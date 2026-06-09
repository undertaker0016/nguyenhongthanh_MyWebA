<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function test1()  {
        return redirect()->route('admin.home');
    }
    public function test2()  {
        return redirect('admin/dashboard');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
    //   $list = DB::table('products as p')
    // ->join('categories as c', 'p.cateid', '=', 'c.cateid')
    // ->leftJoin('brands as b', 'p.brandid', '=', 'b.id')
    // ->select(
    //     'p.id',
    //     'p.productname',
    //     'p.price',
    //     'p.pricediscount',
    //     'p.image',
    //     'p.status',
    //     'c.catename',
    //     'b.brandname'
    // )
    // ->orderBy('p.productname')
    // ->get();

    $list = Product::with([
        'category', 'brand'])
    ->select(
        'id',
        'productname',
        'price',
        'pricediscount',
        'image',
        'status',
        'cateid',
        'brandid')
    ->orderBy('productname')
    ->paginate($limit);
return view('admin.products.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "trang tao product";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "luu product";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "product show: " ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "trang sua product: " ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "trang cap nhat product: " ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "xoa product: " ;
    }
}
