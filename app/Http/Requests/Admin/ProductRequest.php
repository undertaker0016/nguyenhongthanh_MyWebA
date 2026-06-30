<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?: $this->route('product');

        return [
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:150',
                Rule::unique('products', 'productname')->ignore($id),
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:200',
                'regex:/^[A-Za-z0-9_-]+$/',
                Rule::unique('products', 'slug')->ignore($id),
            ],
            'price' => ['required', 'numeric', 'gte:0', 'lt:10000000'],
            'pricediscount' => ['nullable', 'numeric', 'gte:0', 'lte:price'],
            'status' => ['required', 'in:0,1'],
            'cateid' => ['required', 'exists:categories,cateid'],
            'brandid' => ['nullable', 'exists:brands,id'],
            'description' => ['nullable', 'string', 'regex:/^[^@!$^]*$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'regex' => ':attribute không đúng định dạng.',
            'price.numeric' => ':attribute phải là số.',
            'price.gte' => ':attribute phải lớn hơn hoặc bằng 0.',
            'price.lt' => ':attribute phải nhỏ hơn 10.000.000.',
            'pricediscount.numeric' => ':attribute phải là số.',
            'pricediscount.gte' => ':attribute phải lớn hơn hoặc bằng 0.',
            'pricediscount.lte' => ':attribute không được lớn hơn giá gốc.',
            'status.in' => ':attribute không hợp lệ.',
            'cateid.exists' => ':attribute không hợp lệ hoặc chưa tồn tại.',
            'brandid.exists' => ':attribute không hợp lệ hoặc chưa tồn tại.',
            'description.regex' => ':attribute không được chứa ký tự @, !, $, ^.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'price' => 'Giá',
            'pricediscount' => 'Giá khuyến mãi',
            'status' => 'Trạng thái',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả',
        ];
    }
}
