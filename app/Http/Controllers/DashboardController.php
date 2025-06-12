<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Store';
        $user = Auth::user(); // المستخدم الحالي
       
        // تقدر تبعت البيانات للـ view لو محتاج
        return view('dashboard.index',['title'=>$title, 'user'=>$user]);
    }
}
