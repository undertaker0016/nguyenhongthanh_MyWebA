<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( $limit = 10)
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
      $request->validate([
        'catename' => 'required|unique:categories,catename',
        'slug' => 'nullable|unique:categories,slug',
    ]);

    Category::create([
        'catename' => $request->catename,
        'slug' => $request->slug,
        'image' => null,
        'status' => $request->status,
        'sort_order' => $request->sort_order,
        'description' => $request->description,
        
    ]);
    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Thêm loại sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "category show: " ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "trang sua category: " ;
    }   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return  "trang cap nhat category: ";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          DB::table('categories')
        ->where('cateid', $id)
        ->delete();

    return redirect()->route('admin.categories.index');
    }
}
