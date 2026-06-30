<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?: $this->route('user');

        $passwordRules = ['nullable', 'min:6'];
        if ($this->isMethod('post')) {
            $passwordRules = ['required', 'min:6'];
        }

        return [
            'fullname' => ['required', 'min:3', 'max:100'],
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
            'password' => $passwordRules,
            'phone' => ['nullable', 'regex:/^0[0-9]{9}$/'],
            'address' => ['nullable', 'max:255'],
            'gender' => ['nullable', 'in:1,2'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'role' => ['required', 'in:1,2'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'email' => ':attribute phải là một địa chỉ email hợp lệ.',
            'regex' => ':attribute không hợp lệ.',
            'role.in' => ':attribute không hợp lệ.',
            'status.in' => ':attribute không hợp lệ.',
            'gender.in' => ':attribute không hợp lệ.',
            'birthday.date' => ':attribute phải là một ngày hợp lệ.',
            'birthday.before' => ':attribute phải là ngày trước hôm nay.',
            'phone.regex' => ':attribute phải theo định dạng 0xxxxxxxxx.',
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ tên',
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'gender' => 'Giới tính',
            'birthday' => 'Ngày sinh',
            'role' => 'Vai trò',
            'status' => 'Trạng thái',
        ];
    }
}
