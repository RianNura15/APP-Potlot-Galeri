<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
class dashboardController extends Controller
{
    public function index(){
      return view('blog.dashboard');
    }
}
