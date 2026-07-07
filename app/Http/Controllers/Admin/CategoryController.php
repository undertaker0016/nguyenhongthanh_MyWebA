<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Category;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        //=========query builder=========
        // $list = DB::table('categories')
        //     ->select('cateid', 'catename', 'slug', 'image', 'status')
        //     ->where('status', 1)
        //     ->orderBy('catename')
        //     ->get();
        //=========Eloquent ORM=========

        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename')
            ->paginate($limit);
        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    try {

        $request->validate([
            'catename' => 'required|min:3|max:100|unique:categories,catename',
            'slug' => [
                'required',
                'min:3',
                'max:150',
                'regex:/^[a-z0-9-]+$/',
                'unique:categories,slug',
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|max:1000',
            'status' => 'required|in:0,1',
        ],[
            'catename.required' => 'Tên loại sản phẩm không được để trống.',
            'catename.min' => 'Tên loại sản phẩm phải có ít nhất :min ký tự.',
            'catename.max' => 'Tên loại sản phẩm không được vượt quá :max ký tự.',
            'catename.unique' => 'Tên loại sản phẩm đã tồn tại.',

            'slug.required' => 'Slug không được để trống.',
            'slug.min' => 'Slug phải có ít nhất :min ký tự.',
            'slug.max' => 'Slug không được vượt quá :max ký tự.',
            'slug.regex' => 'Slug chỉ được chứa ký tự thường, số và dấu gạch ngang.',
            'slug.unique' => 'Slug đã tồn tại.',

            'image.image' => 'File tải lên phải là hình ảnh.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);


        $fileName = null;


        // Upload hình ảnh sau khi validate
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $fileName = Str::slug($request->catename)
                . '-' . time()
                . '.' . $file->extension();

            $file->storeAs('categories', $fileName, 'public');
        }


        Category::create([
            'catename' => $request->catename,
            'slug' => $request->slug,
            'image' => $fileName,
            'status' => $request->status,
            'sort_order' => $request->sort_order,
            'description' => $request->description,
        ]);


        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Thêm loại sản phẩm thành công!');


    } catch (\Exception $e) {

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Thêm loại sản phẩm thất bại!');
    }
}
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "category show: ";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Validate dữ liệu
        $request->validate(
            // Param 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id . ',cateid',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'status' => 'required|in:0,1'
            ],
            // Param 2: Messages - tùy chỉnh nội dung thông báo lỗi
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.',
                'image.image' => ':attribute phải là hình ảnh.',
                'image.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
                'image.max' => ':attribute không được vượt quá 2048 KB.',
            ],
            // Param 3: Attributes - tên hiển thị của các trường
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'status' => 'Trạng thái',
                'image' => 'Hình ảnh',
            ]
        );

        
        try {
            // Xử lý hình ảnh
            $fileName = $category->image;
            if ($request->hasFile('image')) {
                // Xóa hình ảnh cũ
                if ($category->image) {
                    Storage::disk('public')->delete('categories/' . $category->image);
                }

                // Upload hình ảnh mới
                $file = $request->file('image');
                $fileName = Str::slug($request->catename)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            $category->update([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'status' => $request->status,
                'sort_order' => $request->sort_order,
                'description' => $request->description,
                'image' => $fileName,
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Cập nhật loại sản phẩm thành công!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cập nhật loại sản phẩm thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "category destroy: ";
    }
}
