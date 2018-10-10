<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Books;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Auth;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('admin.common',function ($view) {
            $admin = auth('admin')->user();
//            $book_count = Books::count();
//            $view->with('book_count',$book_count);
            $menu_nav = Cache::remember('menu_children', 60*24, function() {
                $menu_obj = new Menu;
                $menu_nav = $menu_obj->get_menu_children();
                return $menu_nav;
            });
            $view->with(compact('admin','menu_nav'));
        });
        view()->composer('home.common',function ($view) {
            $user = auth('user')->user();
            $view->with(compact('user'));
        });
//        $this->saveSqllog();//记录每次执行sql语句
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function saveSqllog(){
        DB::listen(function ($query) {
            $tmp = str_replace('?', '"' . '%s' . '"', $query->sql);
            $tmp = vsprintf($tmp, $query->bindings);
            $tmp = str_replace("\\", "", $tmp);
            Log::warning($tmp . "\n\n\t");
        });
    }
}
