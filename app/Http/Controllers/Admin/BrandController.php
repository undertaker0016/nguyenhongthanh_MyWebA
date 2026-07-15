<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        //    $list = DB::table('brands')
        //     ->select('id', 'brandname', 'slug', 'image', 'status')
        //     ->where('status', 1)
        //     ->orderBy('brandname')
        //     ->get();
        $list = Brand::select('id', 'brandname', 'slug', 'image', 'status')
            ->orderBy('brandname')
            ->paginate($limit);
        $trashCount = Brand::onlyTrashed()->count();

        return view('admin.brands.index', compact('list', 'trashCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        try {
            // upload hình ảnh (nếu có)
            $fileName = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = Str::slug($request->brandname)
                    . '-' . time()
                    . '.' . $file->extension();
                // hình ảnh được lưu vào thư mục storage/app/public/brands
                $file->storeAs('brands', $fileName, 'public');
            }
            // thực hiện thêm dữ liệu
            Brand::create([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $fileName
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Thêm thương hiệu thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Thêm thương hiệu thất bại!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "brand show: ";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.brands.edit', [
            'brand' => Brand::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        try {
            // Tìm brand theo id
            $brand = Brand::findOrFail($id);
            $fileName = $brand->image;
            if ($request->hasFile('img')) {
                // Xóa hình ảnh cũ
                if ($fileName) {
                    Storage::disk('public')->delete('brands/' . $brand->image);
                }
                // Upload hình ảnh mới
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname)

                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('brands', $fileName, 'public');
            }
            $brand = Brand::findOrFail($id);
            $brand->update([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $fileName,
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thương hiệu thành công!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Cập nhật thương hiệu thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Brand::findOrFail($id)->delete();

            return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Xóa thương hiệu thất bại');
        }
    }

    public function trash()
    {
        $list = Brand::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);

        return view('admin.brands.trash', compact('list'));
    }

    public function restore($id)
    {
        try {
            Brand::onlyTrashed()->findOrFail($id)->restore();

            return redirect()->route('admin.brands.trash')->with('success', 'Khôi phục thương hiệu thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Khôi phục thương hiệu thất bại.');
        }
    }

    public function forceDelete($id)
    {
        try {
            Brand::onlyTrashed()->findOrFail($id)->forceDelete();

            return redirect()->route('admin.brands.trash')->with('success', 'Xóa vĩnh viễn thương hiệu thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Xóa thương hiệu thất bại.');
        }
    }

    public function restoreAll()
    {
        try {
            Brand::onlyTrashed()->restore();

            return redirect()->route('admin.brands.trash')->with('success', 'Khôi phục tất cả thương hiệu thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Khôi phục tất cả thương hiệu thất bại.');
        }
    }

    public function forceDeleteAll()
    {
        try {
            Brand::onlyTrashed()->forceDelete();

            return redirect()->route('admin.brands.trash')->with('success', 'Xóa vĩnh viễn tất cả thương hiệu thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Xóa vĩnh viễn tất cả thương hiệu thất bại.');
        }
    }
}
