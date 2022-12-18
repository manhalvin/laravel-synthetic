<?php

namespace App\Http\Controllers\Demo\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('DemoCheckAge');
        // $this->middleware('DemoCheckAge')->only('index');
        // $this->middleware('DemoCheckAge')->only('index','show');
        // $this->middleware('DemoCheckAge')->except('index','show');
    }
    public function index(){
        return view('demo.admin.index');
    }
}
