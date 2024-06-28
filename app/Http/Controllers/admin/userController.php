<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userController extends Controller
{
  public function anggota_index()
  {
    return view('admin.user.anggota');
  }
  public function customer_index()
  {
    return view('admin.user.customer');
  }
  public function detail_anggota(Request $request)
  {
    $get = db::table('users')->where('id', $request->id)
      ->first();
    return response()->json($get);
  }
  public function edit(Request $request)
  {
    try {
      if (!empty($request->ktp_edit)) {
        $user = db::table('users')
          ->where('id', $request->id_edit)->first();
        $filePathName = 'public/images/ktp/' . $user->ktp;
        if (file_exists($filePathName)) {
          unlink($filePathName);
        }
        $request->validate([
          'ktp_edit' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $request->ktp_edit->extension();
        $request->ktp_edit->move(public_path('images/ktp'), $imageName);
        db::table('users')->where('id', $request->id_edit)
          ->update([
            'ktp' => $imageName
          ]);
      }
      db::table('users')->where('id', $request->id_edit)
        ->update([
          'name' => $request->nama_edit,
          'email' => $request->email_edit,
          'no_hp' => $request->nohp_edit,
        ]);
      return response()->json('berhasil');
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
  }
  public function add_anggota(Request $request)
  {
    $request->validate([
      'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    try {
      //code...
      $imageName = time() . '.' . $request->file->extension();
      $request->file->move(public_path('images/ktp'), $imageName);
      db::table('users')
        ->insert([
          'name' => $request->nama,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'role' => 'anggota',
          'verif' => 'login',
          'no_hp' => $request->noHp,
          'ktp' => $imageName,
          'koderef_mark' => uniqid(),
        ]);
      return response()->json('berhasil', 200);
    } catch (\Throwable $th) {
      //throw $th;
      return response()->json($th->getMessage());
    }
  }
  public function add_pelukis(Request $request)
  {
    $insert = db::table('users')
      ->insert([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'pelukis'
      ]);
    if ($insert == true) {
      return response()->json('berhasil', 200);
    } else {
      return response()->json('gagal', 500);
    }
  }
  public function get_anggota(Request $request)
  {
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('users')
      ->where('role', 'anggota');
    if (!empty($search)) {
      $result = $result->where('name', 'LIKE', '%' . $search . '%')
        ->orwhere('nik', 'LIKE', '%' . $search . '%');
    }
    $get_count = $result->get()->count();
    $result = $result
      ->limit($limit)
      ->offset($offset)
      ->orderBy('created_at', 'DESC')
      ->get();
    foreach ($result as $key => $value) {
      $data[] = array(
        'id' => $value->id,
        'name' => $value->name,
        'email' => $value->email,
        'verif' => $value->verif,
        'koderef_mark' => $value->koderef_mark,
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }
  public function delete_anggota(Request $request)
  {
    $user = db::table('users')
      ->where('id', $request->id)->first();
    $filePathName = 'public/images/ktp/' . $user->ktp;
    if (file_exists($filePathName)) {
      unlink($filePathName);
    }
    $delete = db::table('users')
      ->where('id', $request->id)
      ->delete();
    if ($delete == true) {
      return response()->json('berhasil', 200);
    } else {
      return response()->json('gagal', 500);
    }
  }

  public function generate_koderef(Request $request)
  {
    $generate = db::table('users')
                  ->where('id', $request->id)
                  ->update([
                    'koderef_mark' => uniqid(),
                  ]);
    if ($generate == true) {
      return response()->json('berhasil', 200);
    } else {
      return response()->json('gagal', 500);
    }
  }

  public function verif_anggota(Request $request)
  {
    $verif = db::table('users')
      ->where('id', $request->id)
      ->update([
        'verif' => 'login',
      ]);
    if ($verif == true) {
      return response()->json('berhasil', 200);
    } else {
      return response()->json('gagal', 500);
    }
  }

  public function get_customer(Request $request)
  {
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('users')
      ->where('role', 'customer');
    if (!empty($search)) {
      $result = $result->where('name', 'LIKE', '%' . $search . '%')
        ->orwhere('nik', 'LIKE', '%' . $search . '%');
    }
    $get_count = $result->get()->count();
    $result = $result
      ->limit($limit)
      ->offset($offset)
      ->orderBy('created_at', 'DESC')
      ->get();
    foreach ($result as $key => $value) {
      $data[] = array(
        'id' => $value->id,
        'name' => $value->name,
        'email' => $value->email,
        'verif' => $value->verif,
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }
  public function get_pelukis(Request $request)
  {
    $limit = is_null($request["length"]) ? 10 : $request["length"];
    $offset = is_null($request["start"]) ? 0 : $request["start"];
    $draw = $request["draw"];
    $search = $request->search['value'];
    $data = [];
    $result = DB::table('users')
      ->where('role', 'pelukis');
    if (!empty($search)) {
      $result = $result->where('name', 'LIKE', '%' . $search . '%')
        ->orwhere('nik', 'LIKE', '%' . $search . '%');
    }
    $get_count = $result->get()->count();
    $result = $result
      ->limit($limit)
      ->offset($offset)
      ->orderBy('created_at', 'DESC')
      ->get();
    foreach ($result as $key => $value) {
      $data[] = array(
        'id' => $value->id,
        'name' => $value->name,
        'email' => $value->email,
      );
    }
    $recordsTotal = is_null($get_count) ? 0 : $get_count;
    $recordsFiltered = is_null($get_count) ? 0 : $get_count;
    return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
  }
}
