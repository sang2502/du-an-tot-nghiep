<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use \App\Models\Role;


class UserController extends Controller
{
public function index(Request $request)
    {
        $role = Role::all();
        $query = User::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.user.index', compact('users'));
    }
    public function create()
    {
        // Hiển thị form tạo người dùng mới
        $role = Role::all(); // Lấy danh sách vai trò nếu cần
        return view('admin.user.create' , compact('role'));
    }
    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'points' => $request->points ?? 0, // Mặc định là 0 nếu không có giá trị
            'tier' => $request->tier ?? 'basic', // Mặc định là 'basic' nếu không có giá trị
            'role_id' => $request->role_id, // Lưu ID vai trò
        ]);

        return redirect()->route('user.index')->with('success', 'Tạo tài khoản thành công.');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = Role::all(); // Lấy danh sách vai trò nếu cần
        return view('admin.user.update', compact('user', 'role'));
    }
public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'gender' => $request->gender,
        'birth_date' => $request->birth_date,
        'address' => $request->address,
        'points' => $request->points ?? 0,
        'tier' => $request->tier ?? 'basic',
        'role_id' => $request->role_id,
    ];

    if ($request->filled('password')) {
        $data['password'] = $request->password; // Không mã hóa mật khẩu
    }

    $user->update($data);

    return redirect()->route('user.index')->with('success', 'Cập nhật thành công');
}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Xóa người dùng thành công.');
    }
    public function show($id)
    {
        $role = Role::all();
        $user = User::findOrFail($id);
        return view('admin.user.detail', compact('user' , 'role'));
    }
}
