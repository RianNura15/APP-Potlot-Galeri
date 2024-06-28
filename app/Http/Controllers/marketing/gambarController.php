<?php

namespace App\Http\Controllers\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class gambarController extends Controller
{
  public function index(){
    return view('marketing.gambar.index');
  }
  public function get_data(Request $request){
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('tb_gambar AS a')
    // ->leftjoin('tb_pemasar AS b','a.id','b.id_gambar')
    // ->where('b.id_anggota',$request->id_user)
    ;
    if (!empty($search)) {
      $result = $result->
      where('nama','LIKE','%'.$search.'%')
      // ->orwhere('nik','LIKE','%'.$search.'%')
      ;
    }
    $get_count = $result->get()->count();
    $result = $result
    ->limit($limit)
    ->offset($offset)
    ->get();
    foreach ($result as $key => $value) {
      $data[] = array(
        'id' => $value->id,
        'gambar' => $value->gambar,
        'nama' => $value->nama,
        'keterangan' => $value->keterangan,
        'harga' => $value->harga,
        // 'kategori' => $value->kategori,
        'promo' => $value->promo,
        'gambar' => $value->gambar,
        'created_at' => $value->created_at,
        'updated_at' => $value->updated_at,
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }
  public function tambah_index(){
    return view('marketing.gambar.tambah');
  }
  public function tambah(Request $request){
    $request->validate([
      'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    try {
      $imageName = time().'.'.$request->file->extension();
      $request->file->move(public_path('images'), $imageName);
      $insert = db::table('tb_gambar')
      ->insert([
        'gambar' => $imageName,
        'nama' => $request->nama,
        'keterangan' => $request->keterangan,
        'harga' => $request->harga,
      ]);
      // ->insertGetId([
      //   'gambar' => $imageName,
      //   'nama' => $request->nama,
      //   'keterangan' => $request->keterangan,
      //   'harga' => rupiah($value->harga),
      // ]);
      // db::table('tb_pemasar')
      // ->insert([
      //   'id_gambar' => $insert,
      //   'id_anggota' => $request->id_pemasar
      // ]);
      return response()->json('berhasil',200);
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
  }
  public function index_promo(){
    return view('marketing.gambar.promo');
  }
  public function get_promo(Request $request){
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('tb_gambar AS a')
    ;
    // ->select('a.*','c.name','p.harga_akhir')
    // ->leftJoin('tb_pemasar AS b','a.id','b.id_gambar')
    // ->leftJoin('users AS c','c.id','b.id_anggota')
    // ->leftjoin('promo AS p','p.id_karya','a.id')
    // ->where('b.id_anggota',$request->id_user);
    if (!empty($search)) {
      $result = $result->where('nama','LIKE','%'.$search.'%')
      ->orwhere('keterangan','LIKE','%'.$search.'%')
      ;
      // ->orwhere('c.name','LIKE','%'.$search.'%');
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
        'nama' => $value->nama,
        'gambar' => $value->gambar,
        'keterangan' => $value->keterangan,
        // 'pemasar' => $value->name,
        'harga' => $value->harga,
          // 'harga_promo' => rupiah($value->promo),
        'promo' => $value->promo,
        'harga1' => $value->harga,
        'created_at' => $value->created_at,
        'updated_at' => $value->updated_at,
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }
  public function add_promo(Request $request){
    try {
      // $check = db::table('promo')
      // ->where('id_karya',$request->id_karya)
      // ->first();
      // if (!empty($check)) {
      //   db::table('promo')
      //   ->where('id_karya',$request->id_karya)
      //   ->update([
      //     'potongan' => $request->promo,
      //     'harga_akhir' => $request->harga_akhir,
      //     'created_at' => date('Y-m-d H:i:s')
      //   ]);
      // }else {
      //   db::table('promo')
      //   ->insert([
      //     'id_karya' => $request->id_karya,
      //     'potongan' => $request->promo,
      //     'harga_akhir' => $request->harga_akhir,
      //     'created_at' => date('Y-m-d H:i:s')
      //   ]);
      // }
      $promo = $request->promo == "" ? '0' : $request->promo;
      db::table('tb_gambar')->
      where('id',$request->id_karya)->
      update([
        'promo' => $promo,
      ]);
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }

  }
  public function data_karya(Request $request){
    $get = db::table('tb_gambar')->where('id',$request->id)->first();
    return response()->json($get);
  }
}
