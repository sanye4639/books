<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    public function index()
    {
        $isMobile = isMobile();
        if ($isMobile) {
            return redirect('http://m.sanye666.top');
        } else {
            return view('home.index');
        }
    }
}
