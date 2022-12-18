<?php

namespace App\Http\Controllers\Demo\Projectv1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Demo\DemoDistrict;
use App\Models\Demo\DemoProvince;
use App\Models\Demo\DemoWard;
use App\Models\Demo\Role\DemoRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DemoAdminUserController extends Controller
{
    public function visits()
    {
        return visits($this);
    }
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }

    public function GetDistricts($province_id)
    {
        $district =   DemoDistrict::where('province_id', $province_id)->orderBy('name', 'DESC')->get();
        return json_encode($district);
    }

    public function GetWards($dsistrict_id)
    {
        $ward = DemoWard::where('district_id', $dsistrict_id)->orderBy('name', 'DESC')->get();
        return json_encode($ward);
    }

    public function list(Request $request)
    {
            $user =  new User;
            visits($user)->increment(1);
            $status = $request->status;
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];
            if ($status == 'trash') {
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $users = User::onlyTrashed()->paginate(10);
            } else {
                $keyword = "";
                if ($request->keyword) {
                    $keyword = $request->keyword;
                }
                $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
            }
            $count_user_active = User::count();
            $count_user_trash = User::onlyTrashed()->count();
            $visit =  visits($user)->count();
            $count = [$count_user_active, $count_user_trash];

            return view('demo.projectv1.user.list', compact('users', 'count', 'list_act','visit'));
    }

    public function add()
    {
        // $user =  new User;
        // visits($user)->increment(1);
        // $visit = visits($user)->count();
        $country = Country::all();
        $provinces = DemoProvince::all();
        $roles = DemoRole::get();
        $wards = DemoWard::all();
        $districts = DemoDistrict::all();
        return view('demo.projectv1.user.add', compact('provinces', 'roles','country','wards','districts'));
    }

    public function edit($id)
    {
        // $this->authorize('sua-thanh-vien');
        $user = User::findOrFail($id);
        $roles = DemoRole::get();
        visits($user)->increment(1);
        $visit = visits($user)->count();
        return view('demo.projectv1.user.edit', compact('user', 'roles','visit'));
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max kí tự',
                'min' => ':attribute có độ dài ít nhất :min kí tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu',
                'role_id' => 'Chọn vai trò'
            ]
        );

        User::findOrFail($id)->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);


        $notification = array(
            'message' => 'Bạn đã sửa thành viên thành công',
            'alert-type' => 'success'
        );

        return redirect()->route('projectv1.user.list')->with($notification);
    }

    public function store(Request $request)
    {
        // return $request->role;
        $user =  new User;
        visits($user)->increment(1);
        $visit = visits($user)->count();
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max kí tự',
                'min' => ':attribute có độ dài ít nhất :min kí tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role_id' => 'Chọn vai trò'
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);


        $notification = array(
            'message' => 'Bạn đã thêm thành viên thành công',
            'alert-type' => 'success'
        );

        return redirect()->route('projectv1.user.list')->with($notification);
    }

    public function action(Request $request)
    {
        $list_check = $request->list_check;

        if ($list_check) {

            // Kiểm tra xem thử biến $list_check có tồn tại hay không ?
            // Nếu nó có tồn tại thì chúng ta cần phải duyệt trong mảng $list_check này và chúng ta kiểm tra xem thử id của người đang đăng nhập nó có = 1 id nào ấy ở trong $list_check này hay không ? nêu như = thì chúng ta phải unset cái phần tử ấy ra khỏi mảng
            // => Chúng ta loại bỏ cái việc loại bỏ lên chính bản thân mình
            // Và sau khi chúng ta loại bỏ id của người đang đăng nhập tức là trong mảng $list_check tồn tại những id của thành viên khác mà ko có id của người đang đăng nhập
            // Chúng ta kiểm tra xem thử là biến $list_check có còn khác rỗng hay không ?
            // nếu có khác rỗng (tức là nó có giá trị trong biến)
            foreach ($list_check as $k => $v) {
                if (Auth::id() == $v) {
                    unset($list_check[$k]);
                    // 7
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    $notification = array(
                        'message' => 'Bạn đã xóa tạm thời thành công',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('projectv1.user.list')->with($notification);
                }

                if ($act == 'restore') {
                    User::withTrashed()->whereIn('id', $list_check)->restore();
                    $notification = array(
                        'message' => 'Bạn đã khôi phục thành công',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('projectv1.user.list')->with($notification);
                }

                if ($act == 'forceDelete') {
                    User::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    $notification = array(
                        'message' => 'Bạn đã xóa vĩnh viễn thành công',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('projectv1.user.list')->with($notification);
                }
            }

            $notification = array(
                'message' => 'Bạn không thể thao tác trên tài khoản của mình',
                'alert-type' => 'error'
            );
            return redirect()->route('projectv1.user.list')->with($notification);
        } else {
            $notification = array(
                'message' => 'Bạn cần chọn phần tử cần thực thi',
                'alert-type' => 'error'
            );
            return redirect()->route('projectv1.user.list')->with($notification);
        }
    }

    public function delete($id)
    {
        $this->authorize('xoa-thanh-vien');
        if (Auth::id() != $id) {
            $user = User::findOrFail($id)->delete();
            $notification = array(
                'message' => 'Đã xóa thành viên thành công',
                'alert-type' => 'success'
            );
            return redirect()->route('projectv1.user.list')->with($notification);
        } else {
            $notification = array(
                'message' => 'Bạn không thể tự xóa mình ra khỏi hệ thống',
                'alert-type' => 'error'
            );
            return redirect()->route('projectv1.user.list')->with($notification);
        }
    }
}
