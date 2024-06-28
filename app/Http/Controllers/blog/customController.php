<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response, Auth, PDF;
use App\Services\Midtrans\CreateSnapTokenService;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Illuminate\Support\Str;

class customController extends Controller
{
  public function index(){
    $user = Auth::user()->id;
    $get = db::table('tb_custom AS a')
    ->select('a.*','b.name',)
    ->leftjoin('users AS b','a.id_pemasar','b.id')
    ->where('id_cust',$user)
    ->get();
    return view('blog.custom.index',compact('get'));
  }

  public function tambah(){
    $pemasar = db::table('users')->where('role','anggota')->get();
    return view('blog.custom.tambah',compact('pemasar'));
  }  

  public function create(Request $r)
  {
    $r->validate([
      'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    try {
      $imageName = time().'.'.$r->file->extension();
      $r->file->move(public_path('custom'), $imageName);
      $pemasar = $r->pemasar;
      $cekkoderef = db::table('users')
                    ->where('koderef_mark', $pemasar)
                    ->get();

      $koderef = null;
      foreach ($cekkoderef as $cek) {
        if ($cek->koderef_mark == $pemasar) {
          $koderef = $cek->id;
        }
      }

      db::table('tb_custom')
      ->insert([
        'id_pemasar' => $koderef,
        'id_cust' => Auth::user()->id,
        'sampel' => $imageName,
        'nama' => $r->nama,
        'canvas' => $r->canvas,
        'media' => $r->media,
      ]);
      return response()->json('berhasil',200);
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
  }
  public function createe(Request $request){
    try {
      $imageName = time().'.'.$request->gambar->extension();
      $request->gambar->move(public_path('images'), $imageName);
      db::table('tb_custom')
      ->insert([
        'users_id' => $request->id_users,
        'custom' => $request->keterangan,
        'gambar' => $imageName
      ]);
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
  }
  public function data_list(){
    $get = db::table('tb_custom')
    ->where('id_cust',auth()->user()->id)
    ->get();
    return view('blog.custom.data_list',compact('get'));
  }
  public function batal(Request $request){
    try {
      db::table('tb_custom')
      ->where('id',$request->id)
      ->delete();
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
  }

  public function chat($id)
  {
    $data = [
      'custom' => DB::table('tb_custom')->where('id',$id)->first(),
      'chat' => DB::table('tb_custom_chat')->where('id_custom',$id)->get(),
    ];
    // dd($data);
    return view('blog.custom.chat',compact('data'));
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

  public function get_chat()
  {
    $template='';
    $get = db::table('tb_custom_chat')->where('id_custom',request()->id)->get();
    foreach ($get as $key => $value) {
      if ($value->id_pengirim==Auth()->user()->id) {
        $template .= '
        <div class="text-right">
        <div class="card  d-none d-lg-inline p-2">'.$value->isi.'</div>
        <img class="img-profile rounded-circle" src="'.asset('public/sb_admin/img/undraw_profile.svg').'" width="40px">
        </div>
        ';
      }
      elseif($value->id_penerima==Auth()->user()->id){
        $template .='
        <div class="text-left">
        <img class="img-profile rounded-circle" src="'.asset('public/sb_admin/img/undraw_profile.svg').'" width="40px">
        <div class="card  d-none d-lg-inline p-2">'.$value->isi.'</div>
        </div>
        ';
      }
    }
    return response()->json($template,200);
  }

  public function get_harga(){
    $get = db::table('tb_custom')->where('id',request()->id)->first();
    return response()->json($get->harga,200);
  }

  public function get_bayar(){
    $get = db::table('tb_custom')->where('id',request()->id)->first();
    return response()->json($get->status,200);
  }

  public function get_gb(){
    $gmb = '';
    $a = request()->gambar;
    $get = db::table('tb_custom')->where('id',request()->id)->first()->$a;
    if ($a=='gambar1'&&$get!==NULL) {
      $gmb.='<img class="img-fluid img-thumbnail" src="'.asset('public/custom/gmb1').'/'.$get.'">';
    }
    else if ($a=='gambar2'&&$get!==NULL) {
      $gmb.='<img class="img-fluid img-thumbnail" src="'.asset('public/custom/gmb2').'/'.$get.'">';
    }
    else if ($a=='gambar3'&&$get!==NULL) {
      $gmb.='<img class="img-fluid img-thumbnail" src="'.asset('public/custom/gmb3').'/'.$get.'">';
    }
    else if ($a=='gambar4'&&$get!==NULL) {
      $gmb.='<img class="img-fluid img-thumbnail" src="'.asset('public/custom/gmb4').'/'.$get.'">';
    }
    else{
      $gmb.='gambar belum ada';
    }

    return response()->json($gmb,200);
  }
  public function get_d(){
    $gmb = '';
    $a = request()->gambar;
    $get = db::table('tb_custom')->where('id',request()->id)->first()->$a;
    if ($a=='gambar1'&&$get!==NULL) {
      $gmb.='<a href="'.asset('public/custom/gmb1').'/'.$get.'" target="_blank" class="btn btn-sm btn-success">Lihat</a>';
    }
    else if ($a=='gambar2'&&$get!==NULL) {
      $gmb.='<a href="'.asset('public/custom/gmb2').'/'.$get.'" target="_blank" class="btn btn-sm btn-success">Lihat</a>';
    }
    else if ($a=='gambar3'&&$get!==NULL) {
      $gmb.='<a href="'.asset('public/custom/gmb3').'/'.$get.'" target="_blank" class="btn btn-sm btn-success">Lihat</a>';
    }
    else if ($a=='gambar4'&&$get!==NULL) {
      $gmb.='<a href="'.asset('public/custom/gmb4').'/'.$get.'" target="_blank" class="btn btn-sm btn-success">Lihat</a>';
    }
    else{
      $gmb.='Link Belum Ada';
    }

    return response()->json($gmb,200);
  }
  public function cart_id(Request $request){
    $get = db::table('tb_custom AS a')
    ->select('a.*')
    ->where('a.id',$request->id)
    ->first();
    return response()->json($get);
  }

  public function bayar(Request $request)
  {
    \Midtrans\Config::$serverKey = 'Mid-server-YhEcCIto7B4efBHoSLtkICdN';
    \Midtrans\Config::$isProduction = true;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;
    $id = Str::random(40);
    $id_cart = $request->id;
    $midtrans = [
      'transaction_details' => [
        'order_id' => $id,
        'gross_amount' => $request->gross_amount
      ],
      'customer_details' => [
        'first_name' => $request->name,
        'email' => $request->email,
      ],
      'enable_payments' => [
        "credit_card", "cimb_clicks",
        "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va",
        "bca_va", "bni_va", "bri_va", "other_va", "indomaret", "alfamart",
        "danamon_online", "akulaku", "shopeepay"
      ],
      'vtweb' => []
    ];
    try {
      $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
      $token =  Snap::createTransaction($midtrans)->token;
      $data = [
        'token' => $token,
        'id_cart' => $id_cart
      ];
      return response()->json($data);
    }
    catch (Exception $e) {
      return response()->json($e->getMessage());
    }
  }

  public function payload(Request $request){
    $data = [
      'token' => $request->token,
      'id_cart' => $request->id_cart,
    ];
    return view('blog.custom.showpay',compact('data'));
  }

  public function status(Request $request){
    $get = db::table('tb_custom')
    ->where('id',$request->id_booking)
    ->first();
    $data = json_decode($request->data);
    db::beginTransaction();
    try {
        // $tb_order = db::table('tb_order')
        // ->insertGetId([
        //   'tb_gambar_id' => $get->id_karya,
        //   'users_id' => $get->id_user,
        //   'status' => 'Lunas'
        // ]);
      db::table('tb_custom')
      ->where('id',$request->id_booking)
      ->update([
        'status' => 'dibayar',
      ]);
        // $insert = db::table('tb_payment')
        // ->insert([
        //   'payment_type' => $data->payment_type,
        //   'status_message' => $data->status_message,
        //   'transaction_status' => $data->transaction_status,
        //   'transaction_time' => $data->transaction_time,
        //   'tb_order_id' => $tb_order,
        // ]);
        // db::table('tb_gambar')
        // ->where('id',$get->id_karya)
        // ->update([
        //   'status' => 'dibeli'
        // ]);
      db::commit();
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }

  }

  public function cetak($id)
  {
    // return $id;

    $tgl = date('ymdhis');
    $cstm = DB::table('tb_custom')->find($id);
    // return view('blog.custom.nota',compact('cstm','tgl'));
    $data = PDF::loadview('blog.custom.nota',compact('cstm','tgl'));
    return $data->download('laporan'.$tgl.'.pdf');
  }

  public function ratting(Request $r)
  {
    db::table('tb_custom')->where('id',$r->id)->update([
      'rate' => $r->ratting,
    ]);
    return response()->json('ok',200);
  }

  public function load_ratting(){
    $get = db::table('tb_custom')->where('id',request()->id)->first();
    return response()->json($get->rate,200);
  }
  public function comment(Request $r)
  {
    db::table('tb_custom')->where('id',$r->id)->update([
      'koment' => $r->comment,
    ]);
    return response()->json('ok',200);
  }

  public function load_comment(){
    $get = db::table('tb_custom')->where('id',request()->id)->first();
    return response()->json($get->koment,200);
  }
}
