<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
// 引入 laravel-permission 模型
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Menu;

use Session;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller {
    /**
     * 显示角色列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $roles =  Role::leftJoin('model_has_roles as mr','mr.role_id','=','roles.id')
            ->leftJoin('admins','mr.model_id','=','admins.id')
            ->select(['roles.*',DB::raw('GROUP_CONCAT(`admins`.name) as role_ids')])
            ->groupBy('roles.id')->paginate(15);
        return view('admin.roles.index')->with('roles', $roles);
    }

    /**
     * 显示创建角色表单
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $menu_obj = new Menu;
        $menu_data = $menu_obj->get_menu_children();
        return view('admin.roles.create', compact('menu_data'));
    }

    /**
     * 保存新创建的角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //验证 name 和 permissions 字段
        $this->validate($request, [
                'name'=>'required|unique:roles|max:10',
                'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;
        $role->guard_name = 'admin';

        $permissions = $request['permissions'];

        $role->save();
        // 遍历选择的权限
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            // 获取新创建的角色并分配权限
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role'. $role->name.' added!');
    }

    /**
     * 显示指定角色
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return redirect('roles');
    }

    /**
     * 显示编辑角色表单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = Role::findOrFail($id);

        $menu_obj = new Menu;
        $menu_data = $menu_obj->get_menu_children();
        return view('admin.roles.edit', compact('role','menu_data'));
    }

    /**
     * 更新角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $role = Role::findOrFail($id); // 通过给定id获取角色
        // 验证 name 和 permission 字段
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();//获取所有权限
        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); // 移除与角色关联的所有权限
        }

        foreach ($permissions as $permission) {
            if($permission != 0){
                $p = Permission::where('id', '=', $permission)->firstOrFail(); //从数据库中获取相应权限
                $role->givePermissionTo($p);  // 分配权限到角色
            }
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role'. $role->name.' updated!');
    }

    /**
     * 删除指定权限
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role deleted!');

    }
}