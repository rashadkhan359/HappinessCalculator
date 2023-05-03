<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {   
        return response()->json([
            'status' => 'success',
            'data' => auth()->user(),
        ], 200);
    }

    public function updateProfile(Request $request){
        $user=auth()->user();
        $user->name=$request->name;
        $user->phone=$request->phone;
        $user->save();
        return response()->json([
            'status' => 'success',
            'data' => 'Profile updated successfully',
        ], 200);
    }
}
