<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class adminController extends Controller
{
    public function index(){
      return view('pemilik.admin.index');
    }
    public function get_data(Request $request){
      $limit = is_null($request["length"]) ? 10 : $request["length"];
      $offset = is_null($request["start"]) ? 0 : $request["start"];
      $draw = $request["draw"];
      $search = $request->search['value'];
      $data = [];
      $result = DB::table('users')
      ->where('role','anggota');
      if (!empty($search)) {
        $result = $result->where('name','LIKE','%'.$search.'%')
        ->orwhere('nik','LIKE','%'.$search.'%');
      }
      $get_count = $result->get()->count();
      $result = $result
      ->limit($limit)
      ->offset($offset)
      ->orderBy('created_at','DESC')
      ->get();
      foreach ($result as $key => $value) {
        $data[] = array(
          'id' => $value->id,
          'name' => $value->name,
          'ttl' => $value->ttl,
          'nik' => $value->nik,
        );
      }
      $recordsTotal = is_null($get_count) ? 0 : $get_count;
      $recordsFiltered = is_null($get_count) ? 0 : $get_count;
      return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
    }
}
