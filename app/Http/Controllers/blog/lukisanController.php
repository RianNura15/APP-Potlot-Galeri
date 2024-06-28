<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
use File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class lukisanController extends Controller
{
  public function lukisan_json(){
    $template = '';
    $get = db::table('tb_gambar')
    ->limit(20)
    ->get();
    $a = '';
    foreach ($get as $key => $value) {
      if (File::exists(public_path('images/'.$value->gambar))) {
        if (Auth()->check()) {
          // {{ route('download', ['filename' => 'nama_file.ext']) }}
          $button_download="<a href=".route('download',['gambar'=>$value->gambar])." class='btn btn-sm btn-primary'><i class='fas fa-download ms-2'></i></a>";
        }
        else{
          $button_download="";
        }
        $a.='ada ';
        $template .= '
        <div class="col-md-3 col-lg-3 grid-margin stretch-card">
        <div class="card card-rounded">
        <div class="card-body">
        <div class="portfolio-wrap">
        <img src="'.route('resize_gambar',['gambar'=>$value->gambar]).'" class="img-fluid" alt="">'.
        // '<img src="'.asset('public/images').'/'.$value->gambar.'" class="img-fluid" alt="">'.
        '<div class="portfolio-info">
        <p class="h4"> Lukisan '.$value->nama.'</p>
        <hr>
        <table>
        <tr><td>Hrg Awal</td><td>:</td><td>'.rupiah($value->harga).'</td></tr>
        <tr><td>Diskon</td><td>:</td><td>'.$value->promo.' %</td></tr>
        <tr><td>Hrg Akhir</td><td>:</td><td>'.rupiah($value->harga-($value->promo/100)*$value->harga).'</td></tr>
        </table>
        </div>
        </div>
        <div class="list align-items-center pt-3">
        <div class="wrapper w-100">
        <p class="mb-0">
        <a href="'.route('blog.lukisan.detail',['id'=>$value->id]).'" class="fw-bold btn btn-sm btn-info text-white">Lihat <i class="fas fa-eye ms-2"></i></a>
        '.$button_download.'
        </p>
        </div>
        </div>
        </div>
        </div>
        </div>';
      }
      else{
        $a.='tidak ';
          // $a.=asset('public/images/'.$value->gambar).' ';
        $a.='ada ';
        $template .= '
        <div class="col-md-3 col-lg-3 grid-margin stretch-card">
        <div class="card card-rounded">
        <div class="card-body">
        <div class="portfolio-wrap">
        lukisan telah terhapus
        <div class="portfolio-info">
        <hr>
        <table>
        <tr><td>Hrg Awal</td><td>:</td><td>'.rupiah($value->harga).'</td></tr>
        <tr><td>Diskon</td><td>:</td><td>'.$value->promo.' %</td></tr>
        <tr><td>Hrg Akhir</td><td>:</td><td>'.rupiah($value->harga-($value->promo/100)*$value->harga).'</td></tr>
        </table>
        </div>
        </div>
        <div class="list align-items-center pt-3">
        <div class="wrapper w-100">
        <p class="mb-0">
        <a href="'.route('blog.lukisan.detail',['id'=>$value->id]).'" class="fw-bold btn btn-sm btn-info text-white">Lihat <i class="mdi mdi-arrow-right ms-2"></i></a>
        </p>
        </div>
        </div>
        </div>
        </div>
        </div>';
      }
    }

      // dd($template,$a);

    return response()->json($template,200);
  }
  public function detail(Request $request){
    $id = $request->id;
    $get = db::table('tb_gambar As a')
      // ->leftjoin('promo AS p','p.id_karya','a.id')
    ->where('a.id',$id)
    ->first();
    $pemasar = db::table('users')->where('role','anggota')->get();
      // dd($get);
    return view('blog.detail',compact('get','pemasar'));
  }
}
