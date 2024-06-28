<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class pelukisController extends Controller
{
    public function index(){
      return view('admin.user.pelukis');
    }
}
