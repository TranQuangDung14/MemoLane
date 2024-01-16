<?php

namespace App\Http\Controllers\Search_User;

use App\Http\Controllers\Controller;
use App\Models\Diarys;
use App\Models\User;
use Illuminate\Http\Request;

class SearchUserController extends Controller
{
    //
    public function index(Request $request)
    {
        // dd(Search_Info_User());
        try {
            //code...
            $searchTerm = $request->search;
            $search = User::select('id','name','avatar');
            if ($searchTerm == '') {
                # code...
                // $search = "rỗng";
                $search = User::where('id',0)->get();
            }
            else {
                $search = User::where('name','LIKE', '%' . $request->search . '%')->get();
            }
            // dd($search);
            // $search = User::where('name','LIKE', '%' . $request->search . '%')->get();
            return view('Admin.pages.search_user.Search_User',compact('search','searchTerm'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
