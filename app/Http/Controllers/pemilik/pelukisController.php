<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class pelukisController extends Controller
{
    public function index(){
      return view('pemilik.user.pelukis');
    }
}
