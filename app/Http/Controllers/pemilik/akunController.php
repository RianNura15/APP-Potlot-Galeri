<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class akunController extends Controller
{
  public function admin(){
    return view('pemilik.akun.admin');
  }
  public function anggota(){
    return view('pemilik.akun.marketing');
  }
  public function customer(){
    return view('pemilik.akun.customer');
  }
  public function get_data_admin(Request $request){
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('users')
    ->where('role',$request->role);
    if (!empty($search)) {
      $result = $result->where('name','LIKE','%'.$search.'%');
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
        'role' => $value->role,
        'no_hp' => $value->no_hp,
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }
  public function insert_admin(Request $request){
    $validator = Validator::make($request->all(),[
      'nama' => 'required',
      'email' => 'required',
      'password' => 'required',
      'no_hp' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json('Isi semua form',401);
    }
    db::beginTransaction();
    try {
      db::table('users')
      ->insert([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'no_hp' => $request->no_hp
      ]);
      db::commit();
      return response()->json('berhasil');
    }
    catch (\Exception $e) {
      db::rollback();
      return response()->json($e->getMessage(),500);
    }
  }
  public function hapus(Request $request){
    $id = $request->id;
    try {
      db::table('users')
      ->where('id',$id)
      ->delete();
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage(),500);
    }
  }
  public function show(Request $request){
    $get = db::table('users')->where('id',$request->id)->first();
    return response()->json($get);
  }
  public function update(Request $request){
    try {
      db::table('users')
      ->where('id',$request->id_edit)
      ->update([
        'name' => $request->nama_edit,
        'email' => $request->email_edit,
        'no_hp' => $request->telp_edit
      ]);
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage(),500);
    }

  }
}
