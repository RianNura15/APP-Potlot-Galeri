<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
use Illuminate\Support\Facades\Hash;
class userController extends Controller
{
    public function admin_index(){
      return view('pemilik.user.admin');
    }
    public function anggota_index(){
      return view('pemilik.user.anggota');
    }
    public function customer_index(){
      return view('pemilik.user.customer');
    }
    public function detail_anggota(Request $request){
      $get = db::table('users')->where('id',$request->id)
      ->first();
      return response()->json($get);
    }
    public function edit(Request $request){
      try {
        db::table('users')->where('id',$request->id_edit)
        ->update([
          'name' => $request->nama_edit,
          'email' => $request->email_edit
        ]);
        return response()->json('berhasil');
      } catch (\Exception $e) {
        return response()->json($e->getMessage());
      }
    }
    public function add_admin(Request $request){
      $insert = db::table('users')
      ->insert([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'admin'
      ]);
      if ($insert == true) {
        return response()->json('berhasil',200);
      }else {
        return response()->json('gagal',500);
      }
    }
    public function add_anggota(Request $request){
      $insert = db::table('users')
      ->insert([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'anggota'
      ]);
      if ($insert == true) {
        return response()->json('berhasil',200);
      }else {
        return response()->json('gagal',500);
      }
    }
    public function add_pelukis(Request $request){
      $insert = db::table('users')
      ->insert([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'pelukis'
      ]);
      if ($insert == true) {
        return response()->json('berhasil',200);
      }else {
        return response()->json('gagal',500);
      }
    }
    public function get_anggota(Request $request){
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
          'email' => $value->email,
          'verif' => $value->verif,
        );
      }
      $recordsTotal = is_null($get_count) ? 0 : $get_count;
      $recordsFiltered = is_null($get_count) ? 0 : $get_count;
      return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
    }
    public function delete_anggota(Request $request){
      $delete = db::table('users')
      ->where('id',$request->id)
      ->delete();
      if($delete == true){
        return response()->json('berhasil',200);
      }else {
        return response()->json('gagal',500);
      }
    }

    public function verif_anggota(Request $request){
      $verif = db::table('users')
      ->where('id',$request->id)
      ->update([
        'verif' => 'login',
      ]);
      if($verif == true){
        return response()->json('berhasil',200);
      }else {
        return response()->json('gagal',500);
      }
    }

    public function get_admin(Request $request){
      $limit = is_null($request["length"]) ? 10 : $request["length"];
      $offset = is_null($request["start"]) ? 0 : $request["start"];
      $draw = $request["draw"];
      $search = $request->search['value'];
      $data = [];
      $result = DB::table('users')
      ->where('role','admin');
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
          'email' => $value->email,
          'verif' => $value->verif,
        );
      }
      $recordsTotal = is_null($get_count) ? 0 : $get_count;
      $recordsFiltered = is_null($get_count) ? 0 : $get_count;
      return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
    }
    public function get_customer(Request $request){
      $limit = is_null($request["length"]) ? 10 : $request["length"];
      $offset = is_null($request["start"]) ? 0 : $request["start"];
      $draw = $request["draw"];
      $search = $request->search['value'];
      $data = [];
      $result = DB::table('users')
      ->where('role','customer');
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
          'email' => $value->email,
          'verif' => $value->verif,
        );
      }
      $recordsTotal = is_null($get_count) ? 0 : $get_count;
      $recordsFiltered = is_null($get_count) ? 0 : $get_count;
      return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
    }
    public function get_pelukis(Request $request){
      $limit = is_null($request["length"]) ? 10 : $request["length"];
      $offset = is_null($request["start"]) ? 0 : $request["start"];
      $draw = $request["draw"];
      $search = $request->search['value'];
      $data = [];
      $result = DB::table('users')
      ->where('role','pelukis');
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
          'email' => $value->email,
        );
      }
      $recordsTotal = is_null($get_count) ? 0 : $get_count;
      $recordsFiltered = is_null($get_count) ? 0 : $get_count;
      return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
    }
}
