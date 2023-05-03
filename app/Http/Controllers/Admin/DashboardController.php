<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Icon;
class DashboardController extends Controller
{
    public function index()
    {   
        $usercount=User::where('role_id',2)->count();
        return view('admin.dashboard',compact('usercount'));
        
    }
}
