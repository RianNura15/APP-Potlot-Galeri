<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class karyaController extends Controller
{
    public function index(){
      return view('pemilik.karya.index');
    }
    public function get_data(Request $request){
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
      // ->leftjoin('promo AS p','p.id_karya','a.id');
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
          'harga' => rupiah($value->harga),
          // 'harga_promo' => rupiah($value->promo),
          'promo' => $value->promo,
          'harga1' => $value->harga,
          'created_at' => $value->created_at,
          'updated_at' => $value->updated_at,
        );
      }

      // dd($data);
      $recordsTotal = is_null($get_count) ? 0 : $get_count;
      $recordsFiltered = is_null($get_count) ? 0 : $get_count;
      return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
    }
    public function tambah_index(){
      return view('pemilik.karya.tambah');
    }
    public function tambah(Request $request){
      $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:2048',
      ]);
      try {
        $imageName = time().'.'.$request->file->extension();
        $request->file->move(public_path('images'), $imageName);
        db::table('tb_gambar')
        ->insert([
          'gambar' => $imageName,
          'nama' => $request->nama,
          'keterangan' => $request->keterangan,
          'harga' => $request->harga
        ]);
        return response()->json('berhasil',200);
      } catch (\Exception $e) {
        return response()->json($e->getMessage());
      }
    }
    public function delete(Request $request){
      $id = $request->id;
      db::beginTransaction();
      try {
        db::table('tb_gambar')
        ->where('id',$id)
        ->delete();
        // db::table('tb_pemasar')
        // ->where('id_gambar',$id)
        // ->delete();
        db::commit();
        return response()->json('berhasil',200);
      } catch (\Exception $e) {
        db::rollback();
        return response()->json($e->getMessage());
      }
    }
    public function tambah_pemasar(Request $request){
      $insert = db::table('tb_pemasar')
      ->insert([
        'id_gambar' => $request->id_karya_modal,
        'id_anggota' => $request->pemasar
      ]);
      if ($insert == true) {
        return response()->json('berhasil',200);
      }else {
        return response()->json('gagal',500);
      }
    }
  public function data_karya(Request $request){
    $get = db::table('tb_gambar')->where('id',$request->id)->first();
    return response()->json($get);
  }
}
