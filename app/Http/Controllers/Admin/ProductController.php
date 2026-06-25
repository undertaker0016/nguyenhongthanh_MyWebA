<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
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
        // ========query builder=========
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
 //=========Eloquent ORM=========
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
        $categories = Category::select('cateid', 'catename')
            ->get();
        $brands = Brand::select('id', 'brandname')
            ->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           try {
        $request->validate([
            'productname' => 'required',
            'price' => 'required',
            'cateid' => 'required',
            'brandid' => 'required',

        ]);

        // upload image
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'productname' => $request->productname,
            'slug' => $request->slug,
            'price' => $request->price,
            'pricediscount' => $request->pricediscount,
            'image' => $imagePath,
            'description' => $request->description,
            'status' => $request->status,
            'cateid' => $request->cateid,
            'brandid' => $request->brandid,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');

    } catch (\Exception $e) {
        return back()
            ->with('error', 'Thêm sản phẩm thất bại!')
            ->withInput();
    }
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
        $product = Product::findOrFail($id);
        $categories = Category::select('cateid', 'catename')
            ->orderBy('catename')
            ->get();
        $brands = Brand::select('id', 'brandname')
            ->orderBy('brandname')
            ->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
    $request->validate([
        'productname' => 'required',
        'price' => 'required',
        'cateid' => 'required',     
        'brandid' => 'required',
    ]);

    $product = Product::findOrFail($id);

    $product->update([
        'productname' => $request->productname,
        'slug' => $request->slug,
        'price' => $request->price,
        'pricediscount' => $request->pricediscount,
        'description' => $request->description,
        'status' => $request->status,
        'cateid' => $request->cateid,
        'brandid' => $request->brandid,
    ]);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Cập nhật sản phẩm thành công!');

} catch (\Exception $e) {
    return back()
        ->with('error', 'Cập nhật sản phẩm thất bại!')
        ->withInput();
}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "xoa product: " ;
    }
}
