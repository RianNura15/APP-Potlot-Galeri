<?php

namespace App\Http\Controllers\pelukis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth, Response;
class karyaController extends Controller
{
    public function index(){
      return view('pelukis.karya.index');
    }
    public function tambah_index(){
      return view('pelukis.karya.tambah');
    }

    public function get_data(Request $request){
      $limit = is_null($request["length"]) ? 10 : $request["length"];
      $offset = is_null($request["start"]) ? 0 : $request["start"];
      $draw = $request["draw"];
      $search = $request->search['value'];
      $data = [];
      $result = DB::table('tb_gambar AS a')
      ->select('a.*','c.name','p.harga_akhir')
      ->leftJoin('tb_pemasar AS b','a.id','b.id_gambar')
      ->leftJoin('users AS c','c.id','b.id_anggota')
      ->leftjoin('promo AS p','p.id_karya','a.id')
      ->where('id_pelukis',Auth::user()->id);
      if (!empty($search)) {
        $result = $result->where('nama','LIKE','%'.$search.'%')
        ->orwhere('keterangan','LIKE','%'.$search.'%')
        ->orwhere('c.name','LIKE','%'.$search.'%');
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
          'pemasar' => $value->name,
          'harga' => rupiah($value->harga),
          'harga_akhir' => rupiah($value->harga_akhir),
          'created_at' => $value->created_at
        );
      }
      $recordsTotal = is_null($get_count) ? 0 : $get_count;
      $recordsFiltered = is_null($get_count) ? 0 : $get_count;
      return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
    }
    public function tambah(Request $request){
      $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      try {
        $imageName = time().'.'.$request->file->extension();
        $request->file->move(public_path('images'), $imageName);
        db::table('tb_gambar')
        ->insert([
          'gambar' => $imageName,
          'nama' => $request->nama,
          'keterangan' => $request->keterangan,
          'harga' => $request->harga,
          'id_pelukis' => $request->id_pelukis
        ]);
        return response()->json('berhasil',200);
      } catch (\Exception $e) {
        return response()->json($e->getMessage());
      }
    }
    public function hapus(Request $request){
      try {
        db::table('tb_gambar')
        ->where('id',$request->id)
        ->where('id_pelukis',Auth::user()->id)
        ->delete();
        return response()->json('berhasil');
      } catch (\Exception $e) {
        return response()->json($e->getMessage());
      }

    }
}
