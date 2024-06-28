<?php

namespace App\Http\Controllers\pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;

class customController extends Controller
{
  public function index()
  {
    return view('pemilik.custom.index');
  }

  public function get_data(Request $request)
  {
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('tb_custom AS a');
    if (!empty($search)) {
      $result = $result->where('c.name', 'LIKE', '%' . $search . '%')
        ->orwhere('p.nama', 'LIKE', '%' . $search . '%');
    }
    $get_count = $result->get()->count();
    $result = $result
      ->limit($limit)
      ->offset($offset)
      ->orderBy('a.created_at', 'DESC')
      ->get();
    foreach ($result as $key => $value) {
      $data[] = array(
        'id' => $value->id,
        'gambar' => $value->nama,
        'pembeli' => $value->name,
        'pembayaran' => $value->payment_type,
        'harga' => rupiah($value->harga),
        'status' => $value->status_message,
        'tanggal' => date('d-m-Y', strtotime($value->transaction_time)),
        'flag' => $value->flag
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }
}
