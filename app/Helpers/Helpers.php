<?php

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

if (!function_exists('Search_Info_User')) {
    function Search_Info_User(Request $request)
    {
        // Định nghĩa logic của hàm ở đây
        $search=User::where('name','LIKE', '%' . $request->search . '%')->get();

        return $search;
    }
}

if (!function_exists('follow')) {
    function follow(Request $request)
    {
        // Định nghĩa logic của hàm ở đây
        $follow = Follow::where('user1_id', Auth::user()->id)->where('user2_id', $request->id)->first();
        return $follow;
    }
}



