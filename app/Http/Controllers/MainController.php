<?php

namespace App\Http\Controllers;

use App\Models\Tips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $data=Tips::where('user_id','=',Auth::id())->get();
        $IsAuth=true;
        return [$data,$IsAuth];
    }

    public function create(Request $request)
    {

       $newtip=new Tips();
       $newtip->tips=$request->tip;
       $newtip->user_id=Auth::id();
       $newtip->save();
       return 'ok';
    }

    public function delete(Request $request,$id)
    {
      $tips=Tips::where('id','=',$id)->delete();
      return 'ok';
    }
    public function change(Request $request,$id)
    {
        $tips=Tips::where('id','=',$id)->first();
        $tips->tips=$request->tip;
        $tips->save();
        return $request;
    }
}
