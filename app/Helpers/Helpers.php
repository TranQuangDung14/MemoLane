<?php

use App\Models\User;
use Illuminate\Http\Request;

if (!function_exists('Search_Info_User')) {
    function Search_Info_User(Request $request)
    {
        // Định nghĩa logic của hàm ở đây
        $search=User::where('name','LIKE', '%' . $request->search . '%')->get();
        
        return $search;
    }
}
