<?php

namespace App\Http\Controllers\Demo\Package;

use App\Http\Controllers\Controller;
use App\Http\Requests\Demo\Package\DemoPackageRequest;
use App\Mail\Demo\Package\DemoPackageMail;
use App\Models\Demo\Package\DemoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class DemoPackageController extends Controller
{
    public function index()
    {
        return view('demo.package.index');
    }

    public function list()
    {
        $posts = DemoPost::all();
        return view('demo.package.list',compact('posts'));
    }

    public function add()
    {
        return view('demo.package.add');
    }

    public function store(DemoPackageRequest $request)
    {

        $input = $request->all();
        if ($request->hasFile('image')) {
            // $file = $request->image;
            // // Lấy tên file
            // $filename = $file->getClientOriginalName();
            // // Lấy đuôi file
            // $file->getClientOriginalExtension();
            // // Lấy kích thước file
            // $file->getSize();
            // $path = $file->move('public/uploads/demo/package/images',$filename);
            // $image = 'public/uploads/demo/package/images/'.$filename;
            // $input['image'] =  $image ;
            $image = $request->file('image');
            $name_image = hexdec(uniqid().'.'.$image->getClientOriginalExtension());
            Image::make($image)->resize(100,100)->save('public/uploads/demo/package/images/'.$name_image);
            $last_image = 'public/uploads/demo/package/images/'.$name_image;
            $input['image'] =   $last_image ;
        }
        $input['user_id'] =  1 ;
        DemoPost::create($input);
        return redirect()->route('demo.package.list')->with('status','Thêm bài viết thành công');


    }

    public function sendmail()
    {
        $data = [
            'title' => 'Gửi email từ laravel',
            'content' => 'Nội dung',
        ];
        Mail::to('quocmanh1998s@gmail.com')->send(new DemoPackageMail($data));
    }
}
