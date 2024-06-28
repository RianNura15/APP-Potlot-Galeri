<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response, Auth;
class keranjangController extends Controller
{
  public function index(){
    $user = Auth::user()->id;
    $get = db::table('tb_cart AS a')
    ->select('a.*','c.name','b.gambar')
    ->leftjoin('tb_gambar AS b','a.id_gambar','b.id')
    ->leftjoin('users as c','a.id_pemasar','c.id')
    ->where('id_cust',$user)
    ->get();
        // dd($get);
    return view('blog.keranjang',compact('get'));
  }
  public function tambah(Request $request){
    $id = $request->id;
    $hrg = db::table('tb_gambar')->where('id',$id)->first();
    $user = $request->user;
    $pemasar = $request->pemasar;
    $cekkoderef = db::table('users')
                    ->where('koderef_mark', $pemasar)
                    ->get();

    $koderef = null;
    foreach ($cekkoderef as $cek) {
      if ($cek->koderef_mark == $pemasar) {
        $koderef = $cek->id;
      }
    }

    $check = db::table('tb_cart')
    ->where('id_cust',$user)
    ->where('id_gambar',$id)
    ->where('id_pemasar',$pemasar)
    ->first();
    if (empty($check)){
      $insert = db::table('tb_cart')
      ->insert([
        'id_cust' => $user,
        'id_gambar' => $id,
        'id_pemasar' => $koderef,
        'harga' => $hrg->harga,
        'promo' => $hrg->promo,
      ]);
      if ($insert == true) {
        return response()->json('berhasil',200);
      }
    }else {
      return response()->json('Barang sudah ditambahkan',500);
    }
  }
  public function batal(Request $request){
    try {
      db::table('tb_cart')
      ->where('id',$request->id)
      ->where('id_cust',Auth::user()->id)
      ->delete();
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
  }
  public function cart_id(Request $request){
    $get = db::table('tb_cart AS a')
    ->select('a.*','b.nama','b.gambar')
    ->join('tb_gambar AS b','a.id_gambar','b.id')
    ->where('a.id',$request->id)
    ->first();
    return response()->json($get);
  }
}
