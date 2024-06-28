<?php

namespace App\Http\Controllers\pelukis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth, Response;
class komisiController extends Controller
{
    public function index(){
      return view('pemilik.komisi.index');
    }
    public function get_data(){
      
    }
}
