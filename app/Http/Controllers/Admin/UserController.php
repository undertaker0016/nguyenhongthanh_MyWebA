<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $list = DB::table('users')
        ->select(
            'id',
            'fullname',
            'username',
            'email',
            'phone',
            'role',
            'status'
        )
        ->orderBy('fullname')
        ->get();

     return view('admin.users.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = ['user' => 'Người dùng', 'admin' => 'Quản trị viên'];
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fullname' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'phone' => 'nullable',
                'address' => 'nullable',
                'gender' => 'nullable',
                'birthday' => 'nullable|date',
                'role' => 'required',
                'status' => 'required',
            ]);

            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'role' => $request->role,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Tạo người dùng thành công!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Tạo người dùng thất bại!')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "user show: ";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = ['user' => 'Người dùng', 'admin' => 'Quản trị viên'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'fullname' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:6',
                'phone' => 'nullable',
                'address' => 'nullable',
                'gender' => 'nullable',
                'birthday' => 'nullable|date',
                'role' => 'required',
                'status' => 'required',
            ]);

            $user = User::findOrFail($id);

            $updateData = [
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'role' => $request->role,
                'status' => $request->status,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Cập nhật người dùng thành công!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Cập nhật người dùng thất bại!')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Xóa người dùng thành công!');

        } catch (\Exception $e) {
            return back()->with('error', 'Xóa người dùng thất bại!');
        }
    }
}
