<?php

namespace App\Http\Controllers\Demo\Multi;

use App\Http\Controllers\Controller;
use App\Models\Demo\Image\DemoMultipic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class DemoMultiImageController extends Controller
{
    public function add()
    {
        return view('demo.multipic.add');
    }

    public function deleteAll()
    {
        $muliti = DemoMultipic::all();
        foreach ($muliti as $v) {
            unlink($v->image);
        }
        $item = DemoMultipic::truncate();
        return redirect()
            ->route('demo.multi.list')
            ->with('status', 'Xóa tất cả hình ảnh thành công');
    }

    public function edit($id)
    {
        $item = DemoMultipic::findOrFail($id);
        return view('demo.multipic.edit', compact('item'));
    }

    public function delete($id)
    {
        $product = DemoMultipic::findOrFail($id);
        unlink($product->image);
        DemoMultipic::findOrFail($id)->delete();
        return redirect()
            ->route('demo.multi.list')
            ->with('status', 'Xóa hình ảnh thành công');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $product = DemoMultipic::findOrFail($id);
            unlink($product->image);
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
            $name_image = hexdec(
                uniqid() . '.' . $image->getClientOriginalExtension()
            );
            Image::make($image)
                ->resize(100, 100)
                ->save('public/uploads/demo/package/images/' . $name_image);
            $last_image = 'public/uploads/demo/package/images/' . $name_image;
            $input['image'] = $last_image;

            DemoMultipic::findOrFail($id)->update($input);
            return redirect()
                ->route('demo.multi.list')
                ->with('status', 'Sửa hình ảnh thành công');
        }
    }

    public function list()
    {
        $muliti = DemoMultipic::all();
        return view('demo.multipic.list', compact('muliti'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'image' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $image = $request->file('image');
        if ($image) {
            foreach ($image as $multi_img) {
                $name_image =
                    hexdec(uniqid()) .
                    '.' .
                    $multi_img->getClientOriginalExtension();
                Image::make($multi_img)
                    ->resize(100, 100)
                    ->save('public/uploads/demo/package/images/' . $name_image);
                $last_img = 'public/uploads/demo/package/images/' . $name_image;

                DemoMultipic::insert([
                    'image' => $last_img,
                    'created_at' => Carbon::now(),
                ]);
            }
            return redirect()
                ->route('demo.multi.list')
                ->with('status', 'Thêm hình ảnh thành công');
        } else {
            return redirect()
                ->route('demo.multi.list')
                ->with('error', 'Thất bại khi thêm hình ảnh');
        }
    }

    public function action(Request $request)
    {
        $act = $request->act;
        $list_check = $request->list_check;
        if ($act == 'delete_all') {
            $muliti = DemoMultipic::all();
            foreach ($muliti as $v) {
                unlink($v->image);
            }
            DemoMultipic::destroy($list_check);
            $notification = [
                'message' => 'Bạn đã xóa tất cả hình ảnh thành công',
                'alert-type' => 'success',
            ];
            // return redirect()->route('demo.multi.list')->with($notification);
            return redirect()
                ->route('demo.multi.list')
                ->with('status', 'Xóa tất cả hình ảnh thành công');
        } elseif ($act == 'deletev2') {
            $product = DemoMultipic::whereIn('id', $list_check)->get();
            foreach ($product as $v) {
                unlink($v->image);
            }
            DemoMultipic::whereIn('id', $list_check)->delete();
            return redirect()
                ->route('demo.multi.list')
                ->with('status', 'Xóa hình ảnh thành công');
        } elseif ($act == 'editv2') {
            return  $request->all();
             return $imgs = $request->image['id'];
            foreach ($imgs as $id => $img) {
                // return $id;
                print_r($img);
                exit();
                $imgDel = DemoMultipic::findOrFail($id);
                unlink($imgDel->image);

                $make_name =
                    hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                Image::make($img)
                    ->resize(917, 1000)
                    ->save('public/uploads/demo/package/images/' . $make_name);
                $uploadPath =
                    'public/uploads/demo/package/images/' . $make_name;

                DemoMultipic::where('id', $id)->update([
                    'image' => $uploadPath,
                    'updated_at' => Carbon::now(),
                ]);
            }
            return redirect()
                ->route('demo.multi.list')
                ->with('status', 'Sửa hình ảnh thành công');
        }
    }
}
