<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class TestController extends Controller
{
    public function index($gambar)
    {
        if (File::exists(public_path('images/' . $gambar))) {
            $path = public_path('images/' . $gambar);
            $image = Image::make($path)->resize(200, null, function ($data) {
                $data->aspectRatio();
            });
            return $image->response();
        } else {
            echo 'tidak';
        }
    }

    public function show($email)
    {
        $verif = db::table('users')
            ->where('email', $email)
            ->update([
                'verif' => 'login',
            ]);
        if ($verif == true) {
            return redirect('login');
        } else {
            dd('Gagal Verifikasi');
        }
    }
}
