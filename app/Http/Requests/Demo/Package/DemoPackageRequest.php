<?php

namespace App\Http\Requests\Demo\Package;

use Illuminate\Foundation\Http\FormRequest;

class DemoPackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'bail|required|min:5|max:255|unique:demo_post',
            'content' => 'required',
            'image' =>
                'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return  [
            'title.required' => 'Tiêu đề bắt buộc phải nhập',
            'title.min' => 'Tiêu đề phải từ :min ký tự trở lên',
            'title.max' => 'Tiêu đề phải từ :max ký tự trở lên',
            'title.unique' => 'Tiêu đề đã tồn tại trên hệ thống',
            'content.required' => 'Mô tả bắt buộc phải nhập',
            'image.required' => 'Ảnh đại diện bắt buộc phải có !',
            'image.image' => 'Dữ liệu nhập vào phải là ảnh',
            'image.mimes' =>
                'Chỉ chấp nhận ảnh với đuôi .jpg .jpeg .png .gif',
            'image.max' => 'Ảnh giới hạn dung lượng không quá 2M',
        ];
    }
}
