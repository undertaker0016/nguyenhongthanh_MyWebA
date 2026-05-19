<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    public function index()
    {
        return "product index";
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
