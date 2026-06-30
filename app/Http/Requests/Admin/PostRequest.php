<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?: $this->route('post');

        return [
            'title' => ['required', 'min:3', 'max:200'],
            'slug' => [
                'required',
                'min:3',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('posts', 'slug')->ignore($id),
            ],
            'content' => ['required'],
            'image' => ['nullable', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'slug.unique' => ':attribute đã tồn tại.',
            'user_id.exists' => ':attribute không hợp lệ.',
            'status.in' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'slug' => 'Slug',
            'content' => 'Nội dung',
            'image' => 'Hình ảnh',
            'user_id' => 'Tác giả',
            'status' => 'Trạng thái',
        ];
    }
}
