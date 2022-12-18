<?php

namespace App\Http\Controllers\Demo\Post;

use App\Http\Controllers\Controller;
use App\Models\Demo\Post\DemoPost;
use Illuminate\Http\Request;

class DemoPostController extends Controller
{
    public function read()
    {
        // ORM Database
        // 1. Lấy tất cả bản ghi
        // $posts = DemoPost::all();
        // return $posts;
        // 2. Lấy danh sách  bản ghi theo điều kiện
        // $posts = DemoPost::where('id',1)->get();
        // $posts = DemoPost::where('title','like','%One%')->get();
        // return $posts;
        // 3. Lấy 1 bản ghi theo điều kiện
        // $posts = DemoPost::where('id',1)->first();
        // 4. Lấy 1 bản ghi theo id
        // $posts = DemoPost::findOrFail(1);
        // $posts = DemoPost::find(9); - không nên dùng
        // $posts = DemoPost::find([2,6]);
        // 5. Orderby sắp xếp dữ liệu trong thống kê
        // $posts = DemoPost::orderBy('user_id','desc')->get();
        // return $posts;
        // 6. Tính toán dữ liệu theo nhóm
        // $posts = DemoPost::selectRaw("COUNT('id') as number_posts,user_id")
        // ->groupBy('user_id')
        // ->orderBy('number_posts','desc')
        // ->get();
        // 7. Lấy số bản ghi theo giới hạn
        // $posts = DemoPost::limit(2)->get();
        // $posts = DemoPost::limit(2)
        //     ->offset(2)
        //     ->get();
        // return $posts;
        // 8. Xuất dữ liệu đã xóa tạm thời
        // withTrashed(): xuất dữ liệu - cột delete_at: null và không null
        // $posts = DemoPost::withTrashed()->get();
        // return $posts;
        // $posts = DemoPost::onlyTrashed()->get();
        // return $posts;
        // onlyTrashed(): xuất dữ liệu - cột delete_at: không null
        // 9. Đếm số lượng bản ghi trong bảng:
        // $posts = DemoPost::where('user_id',1)->count();
        // return $posts;
        // 10. Thống kê dữ liệu
        // $posts = DemoPost::min('id');
        // $posts = DemoPost::max('id');
        // $posts = DemoPost::avg('id');
        // return $posts;
        // 11. Join lấy dữ liệu nhiều bảng
        // $posts = DemoPost::join('users','users.id','=','posts.user_id')
        // ->select('users.name','posts.title')
        // ->get();
        // return $posts;
        // 12.Lấy dữ liệu bảng theo điều kiện phức
        // $posts = DemoPost::where(
        //     [
        //         ['title','like','%one%'],
        //         ['user_id','<>',1]
        //     ]
        // )->get();
        // $posts = DemoPost::where('id','>',1)
        // ->orWhere('user_id','=',1)
        // ->get();
        // return $posts;
    }

    public function add()
    {
        // 1.Thêm dữ liệu vào bảng qua phương thức create()
        DemoPost::create([
            'title' => 'Tiêu đề 1',
            'content' => 'Nội dung 1',
            'user_id' => '1',
        ]);
    }

    public function delete($id)
    {
        // DemoPost::findOrFail($id)->delete();
        // DemoPost::find($id)->delete();
        // DemoPost::where('id',$id)->delete();
        // DemoPost::destroy($id);
        // DemoPost::destroy([1,2]);
        // php artisan make:migration add_softdelete_to_posts_tablee --table='posts'
        // Xóa tạm thời dữ liệu với softdelete
        DemoPost::findOrFail($id)->delete();
    }

    public function update($id)
    {
        DemoPost::findOrFail($id)->update([
            'title' => 'Tiêu đề 2',
            'content' => 'Nội dung 2',
            'user_id' => '2',
        ]);
    }

    public function restore($id)
    {
        // Khôi phục lại dữ liệu đã xóa
        DemoPost::onlyTrashed()
            ->findOrFail($id)
            ->restore();
    }

    public function destroy($id)
    {
        // Xóa dữ liệu vĩnh viễn
        DemoPost::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();
    }
}
