<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Menu;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;


class MenuController extends Controller {

    public function index() {
        $menu_obj = new Menu;
        $menu = $menu_obj->get_menu_list();
        return view('admin.menu.index',compact('menu'));
    }

    public function create() {
        $menu_obj = new Menu;
        $menu_list = $menu_obj->get_menu_list();
        return view('admin.menu.create',compact('menu_list'));
    }

    public function store(Request $request) {
        $data = $this->validate($request, [
            'menu_name'=>'required|max:50|unique:menu',
            'pid'=>'required'
        ]);
        $data['dstatus'] = ($request->dstatus == 'on')?'1':'0';
        $data['ac'] = ($request->ac) ?? '';
        $data['url_params'] = ($request->url_params) ?? '';
        $data['icon_class'] = ($request->icon_class) ?? '';
        if(!empty($data['ac'])){
            $permission = Permission::create(['name' => $data['ac'],'guard_name'=>'admin']);
            if($permission){
                $data['permission_id'] = $permission->id;
            }
        }
        Menu::create($data);
        Cache::forget('menu_children');

        return redirect()->route('menu.index')->with('flash_message','Menu'. $data['menu_name'].' added!');
    }

    /**
     * 显示编辑菜单表单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $menu = Menu::findOrFail($id); // 通过给定id获取菜单
        $menu_obj = new Menu;
        $menu_list = $menu_obj->get_menu_list();
        return view('admin.menu.edit', compact('menu','menu_list')); // 将用户和角色数据传递到视图

    }

    public function update(Request $request, $id) {
        $data = $this->validate($request, [
            'menu_name'=>'required|max:50|unique:menu,menu_name,'.$id,
            'pid'=>'required|int',
        ]);
        $data['dstatus'] = ($request->dstatus == 'on')?'1':'0';
        $data['ac'] = ($request->ac) ?? '';
        $data['url_params'] = ($request->url_params) ?? '';
        $data['icon_class'] = ($request->icon_class) ?? '';

        Menu::where('id',$id)->update($data);

        $menu = Menu::findOrFail($id);
        if(!empty($menu->permission_id)){
            Permission::whereId($menu->permission_id)->update(['name'=>$data['ac']]);
        }
        Cache::forget('menu_children');

        return redirect()->route('menu.index')->with('flash_message','Menu'. $data['menu_name'].' updated!');
    }


    /**
     * 删除指定菜单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        if($menu->permission_id){
            $permission = Permission::findOrFail($menu->permission_id);
            $permission->delete();
        }
        Cache::forget('menu_children');
        return redirect()->route('menu.index')->with('flash_message','Menu deleted!');
    }

}