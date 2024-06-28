<?php

namespace App\Http\Controllers\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response, Auth;
class transaksiController extends Controller
{
  public function index(){
    return view('marketing.transaksi.index');
  }

  public function pesan()
  {
    $user = Auth::user()->id;
    $get = db::table('tb_cart AS a')
    ->select('a.*','a.harga as harga_akhir','b.promo','b.nama','b.harga','b.gambar','z.name','a.status')
    ->join('tb_gambar AS b','a.id_gambar','b.id')
    ->leftjoin('users as z','a.id_cust','z.id')
    ->where('id_pemasar',$user)
    ->get();
    // dd($get);
    return view('marketing.transaksi.pesan',compact('get'));
  }

  public function custom()
  {
    $user = Auth::user()->id;
    $get = db::table('tb_custom AS a')
    ->select('a.*','b.name','b.name')
    ->leftjoin('users AS b','a.id_cust','b.id')
    ->where('id_pemasar',$user)
    ->get();
    return view('marketing.transaksi.custom',compact('get'));
  }

  public function chat($id){
    $data = [
      'custom' => DB::table('tb_custom')->find($id),
      'chat' => DB::table('tb_custom_chat')->where('id_custom',$id)->get(),
    ];
    // dd($data['custom']);
    return view('marketing.transaksi.chat',compact('data'));
  }

  public function p_chat(Request $r){
    if ($r->pesan!="") {
      db::table('tb_custom_chat')->insert([
        'id_custom' =>$r->chat,
        'id_pengirim' =>Auth()->user()->id,
        'id_penerima' =>$r->penerima,
        'isi' =>$r->pesan,
      ]);
      return response()->json($r->pesan,200);
    }
    else{
      return response()->json('Pesan Tidak Boleh Kosong',500);
    }
  }

  public function p_harga()
  {
    if(request()->harga!=0) {
      db::table('tb_custom')->where('id',request()->id)->update([
        'harga' =>request()->harga,
      ]);
      return response()->json(request()->harga,200);
    }
    else{
      return response()->json('0',500);
    }
  }

  public function lukis1(Request $r,$id)
  {
    $r->validate([
      'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    if ($r->gambar=='file1') {
      $imageName = time().'.'.$r->file->extension();
      $r->file->move(public_path('custom/gmb1/'), $imageName);
      db::table('tb_custom')->where('id',$id)->update([
        'gambar1' => $imageName,
      ]);
      return redirect('marketing/transaksi/chat/'.$id);
    }
    else if ($r->gambar=='file2') {
      $imageName = time().'.'.$r->file->extension();
      $r->file->move(public_path('custom/gmb2/'), $imageName);
      db::table('tb_custom')->where('id',$id)->update([
        'gambar2' => $imageName,
      ]);
      return redirect('marketing/transaksi/chat/'.$id);
    }
    else if ($r->gambar=='file3') {
      $imageName = time().'.'.$r->file->extension();
      $r->file->move(public_path('custom/gmb3/'), $imageName);
      db::table('tb_custom')->where('id',$id)->update([
        'gambar3' => $imageName,
      ]);
      return redirect('marketing/transaksi/chat/'.$id);
    }
    else if ($r->gambar=='file4') {
      $imageName = time().'.'.$r->file->extension();
      $r->file->move(public_path('custom/gmb4/'), $imageName);
      db::table('tb_custom')->where('id',$id)->update([
        'gambar4' => $imageName,
      ]);
      return redirect('marketing/transaksi/chat/'.$id);
    }
    dd($id,$r);
  }

  public function lukis2(Request $r)
  {

  }

  public function lukis3(Request $r)
  {

  }

  public function lukis4(Request $r)
  {

  }

  public function get_chat()
  {
    $template='';
    $get = db::table('tb_custom_chat')->where('id_custom',request()->id)->get();
    foreach ($get as $key => $value) {
      if ($value->id_pengirim==Auth()->user()->id) {
        $template .= '
        <div class="text-right">
        <div class="card d-lg-inline p-2">'.$value->isi.'</div>
        <img class="img-profile rounded-circle" src="'.asset('public/sb_admin/img/undraw_profile.svg').'" width="40px">
        </div>
        ';
      }
      elseif($value->id_penerima==Auth()->user()->id){
        $template .='
        <div class="text-left">
        <img class="img-profile rounded-circle" src="'.asset('public/sb_admin/img/undraw_profile.svg').'" width="40px">
        <div class="card d-lg-inline p-2">'.$value->isi.'</div>
        </div>
        ';
      }
    }
    return response()->json($template,200);
  }

  public function get_data(Request $request){
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('tb_order AS a')
    ->select('a.*','c.name','p.harga','p.nama','d.transaction_time','d.payment_type','d.status_message')
    ->leftJoin('tb_pemasar AS b','a.tb_gambar_id','b.id_gambar')
    ->leftJoin('users AS c','c.id','a.users_id')
    ->leftjoin('tb_gambar AS p','p.id','a.tb_gambar_id')
    ->leftJoin('tb_payment AS d','d.tb_order_id','a.id')
    ->where('b.id_anggota',$request->user_id);
    if (!empty($search)) {
      $result = $result->where('c.name','LIKE','%'.$search.'%')
      ->orwhere('p.nama','LIKE','%'.$search.'%');
    }
    $get_count = $result->get()->count();
    $result = $result
    ->limit($limit)
    ->offset($offset)
    ->orderBy('a.created_at','DESC')
    ->get();
    foreach ($result as $key => $value) {
      $data[] = array(
        'id' => $value->id,
        'gambar' => $value->nama,
        'pembeli' => $value->name,
        'pembayaran' => $value->payment_type,
        'harga' => rupiah($value->harga),
        'status' => $value->status_message,
        'tanggal' => date('d-m-Y',strtotime($value->transaction_time)),
        'flag' => $value->flag
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }

  public function get_harga()
  {
    $get = db::table('tb_custom')->where('id',request()->id)->first();
    return response()->json($get->harga,200);
  }

  public function get_bayar(){
    $get = db::table('tb_custom')->where('id',request()->id)->first();
    return response()->json($get->status,200);
  }

  public function verifikasi(Request $request){
    try {
      db::table('tb_order')
      ->where('id',$request->id)
      ->update([
        'flag'=>'verif'
      ]);
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }

  }
}
