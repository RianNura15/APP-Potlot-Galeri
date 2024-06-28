<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class anggotaController extends Controller
{
    public function get_json(Request $request){
      $get = db::table('users')
      ->where('role','anggota')
      ->get();
      return response()->json($get,200);
    }
}
