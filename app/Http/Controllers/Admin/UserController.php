<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $list = User::orderBy('fullname')->get();

        return view('admin.users.index', compact('list'));
    }

    public function create()
    {
        $roles = [
            1 => 'Người dùng',
            2 => 'Quản trị viên',
        ];

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|min:3|max:100',
            'username' => 'required|min:3|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'address' => 'nullable|max:255',
            'gender' => 'nullable|in:1,2',
            'birthday' => 'nullable|date|before:today',
            'role' => 'required|in:1,2',
            'status' => 'required|in:0,1',
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

        return redirect()->route('admin.users.index')
            ->with('success', 'Thêm user thành công!');
    }
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'fullname' => 'required|min:3|max:100',
            'username' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('users', 'username')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => 'nullable|min:6',
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'address' => 'nullable|max:255',
            'gender' => 'nullable|in:1,2',
            'birthday' => 'nullable|date|before:today',
            'role' => 'required|in:1,2',
            'status' => 'required|in:0,1',
        ]);

        $data = [
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
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật user thành công!');
    }


    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $roles = [
            1 => 'Người dùng',
            2 => 'Quản trị viên',
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }
    public function destroy(string $id)
    {
        return "user destroy: ";
    }
}
