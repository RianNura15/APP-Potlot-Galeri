<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class promoController extends Controller
{
    public function index(){
      return view('admin.promo.index');
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
    
}
