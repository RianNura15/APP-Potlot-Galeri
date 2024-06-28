<?php

namespace App\Http\Controllers\pelukis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dahsboardController extends Controller
{
  public function home(){
    return view('pelukis.home');
  }
}
