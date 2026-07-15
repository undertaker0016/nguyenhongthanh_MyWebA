<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
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
        $trashCount = Product::onlyTrashed()->count();

        return view('admin.products.index', compact('list', 'trashCount'));
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
    public function store(ProductRequest $request)
    {
        try {
            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            // Lưu sản phẩm
            $product = Product::create([
                'productname' => $request->productname,
                'slug' => $request->slug,
                'cateid' => $request->cateid,
                'brandid' => $request->brandid,
                'price' => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description' => $request->description,
                'status' => $request->status,
                'image' => $fileName,
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('images')) {
                $i = 1;
                $time = time();
                foreach ($request->file('images') as $file) {
                    $fileName = $product->id
                        . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileName, 'public');

                    // Lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileName,
                    ]);
                    $i++;
                }
            }

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
        $product = Product::with('images')->findOrFail($id);
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
    public function update(ProductRequest $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Xử lý hình ảnh chính
            if ($request->hasFile('image')) {
                // Xóa hình ảnh cũ
                if ($product->image) {
                    Storage::disk('public')->delete('products/' . $product->image);
                }

                // Upload hình ảnh mới
                $file = $request->file('image');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
                $product->image = $fileName;
            }

            // Cập nhật thông tin sản phẩm
            $product->update([
                'productname' => $request->productname,
                'slug' => $request->slug,
                'price' => $request->price,
                'pricediscount' => $request->pricediscount,
                'description' => $request->description,
                'status' => $request->status,
                'cateid' => $request->cateid,
                'brandid' => $request->brandid,
                'image' => $product->image,
            ]);

            // Xử lý hình ảnh phụ
            if ($request->hasFile('images')) {
                $i = 1;
                $time = time();
                foreach ($request->file('images') as $file) {
                    $fileName = $product->id
                        . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileName, 'public');

                    // Lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileName,
                    ]);
                    $i++;
                }
            }

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
        try {
            Product::findOrFail($id)->delete();

            return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Xóa sản phẩm thất bại');
        }
    }

    public function trash()
    {
        $list = Product::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);

        return view('admin.products.trash', compact('list'));
    }

    public function restore($id)
    {
        try {
            Product::onlyTrashed()->findOrFail($id)->restore();

            return redirect()->route('admin.products.trash')->with('success', 'Khôi phục sản phẩm thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Khôi phục sản phẩm thất bại.');
        }
    }

    public function forceDelete($id)
    {
        try {
            Product::onlyTrashed()->findOrFail($id)->forceDelete();

            return redirect()->route('admin.products.trash')->with('success', 'Xóa vĩnh viễn sản phẩm thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Xóa sản phẩm thất bại.');
        }
    }

    public function restoreAll()
    {
        try {
            Product::onlyTrashed()->restore();

            return redirect()->route('admin.products.trash')->with('success', 'Khôi phục tất cả sản phẩm thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Khôi phục tất cả sản phẩm thất bại.');
        }
    }

    public function forceDeleteAll()
    {
        try {
            Product::onlyTrashed()->forceDelete();

            return redirect()->route('admin.products.trash')->with('success', 'Xóa vĩnh viễn tất cả sản phẩm thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Xóa vĩnh viễn tất cả sản phẩm thất bại.');
        }
    }

    /**
     * Delete product image.
     */
    public function deleteImage(string $imageId)
    {
        try {
            $productImage = ProductImage::findOrFail($imageId);
            
            // Xóa file từ storage
            Storage::disk('public')->delete('products/' . $productImage->image);
            
            // Xóa record từ database
            $productImage->delete();

            return redirect()->back()->with('success', 'Xóa hình ảnh thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa hình ảnh thất bại!');
        }
    }
}
