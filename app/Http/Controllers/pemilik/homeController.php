<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class homeController extends Controller
{
  public function index(){
    return view('pemilik.home');
  }

  public function detail($id)
  {
    return view('pemilik.gaji.index',compact('id'));
  }

  public function gaji($id)
  {
    if (request()->gajian<=0) {
      return redirect('pemilik/home/detail'.'/'.$id);
    }
    else{
      DB::table('tb_gaji')->insert([
       'id_user' => $id,
       'gaji' => request()->gajian,
     ]);
      return redirect('pemilik/home/detail'.'/'.$id);
    }
  }
  public function delete($id,$tgl)
  {
    $delete = DB::table('tb_gaji')->
    where('id_user',$id)->
    where('tgl_gaji',$tgl)->
    delete();
    if ($delete) {
      return redirect('pemilik/home/detail'.'/'.$id);
    }
    else{
      return redirect('pemilik/home/detail'.'/'.$id);
    }
  }
  public function ubah(Request $request,$id,$tgl)
  {
    // dd($request,$id,$tgl);
    $update=DB::table('tb_gaji')->
    where('id_user',$id)->
    where('tgl_gaji',$tgl)->
    update([
      'gaji'=>$request->gajian,
    ]);
    if ($update) {
      return redirect('pemilik/home/detail'.'/'.$id);
    }
    else{
      return redirect('pemilik/home/detail'.'/'.$id);
    }
  }
}
