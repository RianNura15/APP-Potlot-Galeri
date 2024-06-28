<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\emailVerifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Mail;

class DaftarController extends Controller
{
	public function customer(Request $request)
	{
		$this->validate($request, [
			'name' => ['required'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required'],
		]);

		User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'verif'	=> 'login',
		]);

		Mail::to($request->email)->send(new emailVerifikasi($request->email, $request->name));

		return redirect('login');
		dd($request);
	}
	public function marketing(Request $request)
	{
		$this->validate($request, [
			'name' => ['required'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required'],
		]);

		User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'role' => 'anggota',
		]);

		return redirect('login');
		dd($request);
	}
}
