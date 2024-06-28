<?php

namespace App\Http\Controllers\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response, Auth;
use Illuminate\Support\Collection;

class dashboardController extends Controller
{
  public function home(){
    $data_cart = DB::table('tb_cart')
    ->select('harga')
    ->where('id_pemasar','=',Auth()->user()->id)
      // ->where('id_pemasar','=',Auth()->user()->id)
      // ->where('status','=','dibayar')
      // ->groupby('id_pemasar')
    ->get();
    $data_custom = DB::table('tb_custom')
    ->select('harga')
    ->where('id_pemasar','=',Auth()->user()->id)
      // ->where('id_pemasar','=',Auth()->user()->id)
      // ->where('status','=','dibayar')
      // ->groupby('id_pemasar')
    ->get();
    $komisi = 0;
    foreach ($data_cart as $key => $value) {
      $komisi +=$value->harga;
    }
    foreach($data_custom as $key => $value) {
      $komisi +=$value->harga;
    }
    $komisi;

    $totalcart = 0;
    foreach ($data_cart as $key => $value) {
      $totalcart += $value->harga;
    }
    $totalcart;

    $totalcustom = 0;
    foreach ($data_custom as $key => $value) {
      $totalcustom += $value->harga;
    }
    $totalcustom;

    $data_peringkat = [];

    foreach(DB::table('users')->where('role','=','anggota')->get() as $key => $value){
      $data_cart = DB::table('tb_cart')
      ->select('harga')
      ->where('id_pemasar','=',$value->id)
      ->get();
      $data_custom = DB::table('tb_custom')
      ->select('harga')
      ->where('id_pemasar','=',$value->id)
      ->get();
      $total_komisi = 0;
      foreach ($data_cart as $key_cart => $value_cart) {
        $total_komisi +=$value_cart->harga;
      }
      foreach($data_custom as $key_custom => $value_custom) {
        $total_komisi +=$value_custom->harga;
      }
      // $komisi = 10/100*$komisi;
      array_push($data_peringkat,[
        'nama'=>$value->id,
        'hasil'=>$total_komisi,
      ]);
    }

    $sortedCollection = collect($data_peringkat)->sortByDesc(function ($item) {
      return $item['hasil'];
    });

    $peringkat = 0;
    $peringkat_anda=0;
    foreach ($sortedCollection as $key => $value) {
      $peringkat++;
      if($value['nama']==Auth()->user()->id){
        $peringkat_anda=$peringkat;
      }
    }

    $data = [
      'totalcart'=>$totalcart,
      'totalcustom'=>$totalcustom,
      'komisi'=>$komisi,
      'data_peringkat'=>$sortedCollection,
      'peringkat_anda'=>$peringkat_anda,
    ];
    // dd($data);
    return view('marketing.index',compact('data'));
  }
}
