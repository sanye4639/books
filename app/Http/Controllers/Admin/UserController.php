<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use Auth;

// 引入 laravel-permission 模型
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// 用于输出一次性信息
use Session;

class UserController extends Controller {
    /**
     * 显示用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //Get all users and pass it to the view
        $users = Admin::paginate(15);
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * 显示创建用户角色表单
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // 获取所有角色并将其传递到视图
        $roles = Role::get();
        return view('admin.users.create', ['roles'=>$roles]);
    }

    /**
     * 在数据库中保存新创建的资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // 验证 name、email 和 password 字段
        $this->validate($request, [
            'name'=>'required|max:120',
            'phone'=>'required|numeric|unique:admins',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = Admin::create($request->only('phone', 'name', 'password')); //只获取 email、name、password 字段

        $roles = $request['roles']; // 获取输入的角色字段
        // 检查是否某个角色被选中
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            }
        }
        // 重定向到 users.index 视图并显示消息
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully added.');
    }

    /**
     * 显示指定用户
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return redirect('users');
    }

    /**
     * 显示编辑用户角色表单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = Admin::findOrFail($id); // 通过给定id获取用户
        $roles = Role::get(); // 获取所有角色
        $user_roles = $user->roles()->pluck('name')->toarray();

        return view('admin.users.edit', compact('user', 'roles','user_roles')); // 将用户和角色数据传递到视图

    }

    /**
     * 更新数据库中的给定用户
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = Admin::findOrFail($id); // 通过id获取给定角色

        // 验证 name, email 和 password 字段
        $this->validate($request, [
            'name'=>'required|max:120',
            'phone'=>'required|numeric|unique:admins,phone,'.$id,
        ]);
        $input = $request->only(['name', 'phone', 'password']); // 获取 name, email 和 password 字段
        $roles = $request['roles']; // 获取所有角色
        if (empty($input['password'])){
            unset($input['password']);
        }
        $user->fill($input)->save();

        if (isset($roles)) {
            $user->roles()->sync($roles);  // 如果有角色选中与用户关联则更新用户角色
        } else {
            $user->roles()->detach(); // 如果没有选择任何与用户关联的角色则将之前关联角色解除
        }
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * 删除用户
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // 通过给定id获取并删除用户
        $user = Admin::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully deleted.');
    }
}