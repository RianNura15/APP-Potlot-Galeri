<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response, PDF;
class pembayaranController extends Controller
{
  public function index(){
    return view('pemilik.pembayaran.index');
  }

  public function detail($id)
  { 
    $data = [
      'cart' => DB::table('tb_cart')->where('id_pemasar',$id)->get(),
      'markt' => DB::table('users')->find($id),
    ];
    return view('pemilik.pembayaran.detail',compact('data'));
  }

  public function detail_c($id)
  { 
    $data = [
      'cart' => DB::table('tb_custom')->where('id_pemasar',$id)->get(),
      'markt' => DB::table('users')->find($id),
    ];
    return view('pemilik.pembayaran.detail_c',compact('data'));
  }

  public function cetak($id)
  {
    $tgl = date('ymdhis');
    $data = [
      'user' => DB::table('users')->find($id),
      'data' => DB::table('tb_cart')->where("id_pemasar",$id)->get(),
    ];
    // return view('pemilik.pembayaran.cetak',compact('data','tgl'));
    $data = PDF::loadview('pemilik.pembayaran.cetak',compact('data','tgl'));
    return $data->download('laporan_pendapatan_'.DB::table('users')->find($id)->name."_".$tgl.'.pdf');
  }

  public function cetak_c($id)
  {
    $tgl = date('ymdhis');
    $data = [
      'user' => DB::table('users')->find($id),
      'data' => DB::table('tb_custom')->where("id_pemasar",$id)->get(),
    ];
    // return view('pemilik.pembayaran.cetak_c',compact('data','tgl'));
    $data = PDF::loadview('pemilik.pembayaran.cetak_c',compact('data','tgl'));
    return $data->download('laporan_pendapatan_'.DB::table('users')->find($id)->name."_".$tgl.'.pdf');
  }

  public function get_data(Request $request){
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];

    $result = DB::table('users')
      // ->select('id','name','email')
      // ->leftjoin('tb_cart','tb_cart.id_pemasar','users.id')
    ->where('role','anggota');

    if (!empty($search)) {
      $result = $result
      ->where('name','LIKE','%'.$search.'%')
      ->orwhere('email','LIKE','%'.$search.'%')
      ->where('role','anggota')
      ;
    }

    $get_count = $result->get()->count();

    $result = $result
    ->limit($limit)
    ->offset($offset)
    ->orderBy('created_at','DESC')
    ->get();

    foreach ($result as $key => $value) {
      $x = db::table('tb_cart')->where('id_pemasar',$value->id)->get();
      $y = 0;
      $z = 0;
      foreach ($x as $ky => $val) {
        if ($val->status=='pesan') {
          $y = $y+$val->harga;
        }
        else if ($val->status=='dibayar') {
          $z = $z+$val->harga;
        }
      }
      $data[] = array(
        'id' => $value->id,
        'name' => $value->name,
        'email' => $value->email,
        'sudah' => rupiah($y),
        'belum' => rupiah($z),
      );
    }
      // dd($data);
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }

  public function custom()
  {
    return view('pemilik.pembayaran.custom');
  }

  public function get_data_custom(Request $request)
  {
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];

    $result = DB::table('users')
      // ->select('id','name','email')
      // ->leftjoin('tb_cart','tb_cart.id_pemasar','users.id')
    ->where('role','anggota');

    if (!empty($search)) {
      $result = $result
      ->where('name','LIKE','%'.$search.'%')
      ->orwhere('email','LIKE','%'.$search.'%')
      ->where('role','anggota')
      ;
    }

    $get_count = $result->get()->count();

    $result = $result
    ->limit($limit)
    ->offset($offset)
    ->orderBy('created_at','DESC')
    ->get();

    foreach ($result as $key => $value) {
      $x = db::table('tb_custom')->where('id_pemasar',$value->id)->get();
      $y = 0;
      $z = 0;
      foreach ($x as $ky => $val) {
        if ($val->status=='pesan') {
          $y = $y+$val->harga;
        }
        else if ($val->status=='dibayar') {
          $z = $z+$val->harga;
        }
      }
      $data[] = array(
        'id' => $value->id,
        'name' => $value->name,
        'email' => $value->email,
        'sudah' => rupiah($y),
        'belum' => rupiah($z),
      );
    }
      // dd($data);
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }


}
