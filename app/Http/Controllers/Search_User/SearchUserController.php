<?php

namespace App\Http\Controllers\Search_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchUserController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('Admin.pages.search_user.Search_User');
    }
}
