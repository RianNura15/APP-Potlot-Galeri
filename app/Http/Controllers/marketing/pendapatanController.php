<?php

namespace App\Http\Controllers\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB, Response, Auth;

class pendapatanController extends Controller
{
	// public function index()
	// {
	// 	$jn = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'01')->get();$jan = 0.0;foreach ($jn as $jn){$jan = $jan+$jn->harga;}
	// 	$fb = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'02')->get();$feb = 0.0;foreach ($fb as $fb){$feb = $feb+$fb->harga;}
	// 	$mr = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'03')->get();$mar = 0.0;foreach ($mr as $mr){$mar = $mar+$mr->harga;}
	// 	$ap = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'04')->get();$apr = 0.0;foreach ($ap as $ap){$apr = $apr+$ap->harga;}
	// 	$me = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'05')->get();$may = 0.0;foreach ($me as $me){$may = $may+$me->harga;}
	// 	$jn = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'06')->get();$jun = 0.0;foreach ($jn as $jn){$jun = $jun+$jn->harga;}
	// 	$ju = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'07')->get();$jul = 0.0;foreach ($ju as $ju){$jul = $jul+$ju->harga;}
	// 	$ag = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'08')->get();$aug = 0.0;foreach ($ag as $ag){$aug = $aug+$ag->harga;}
	// 	$sp = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'09')->get();$sep = 0.0;foreach ($sp as $sp){$sep = $sep+$sp->harga;}
	// 	$oc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'10')->get();$oct = 0.0;foreach ($oc as $oc){$oct = $oct+$oc->harga;}
	// 	$nv = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'11')->get();$nov = 0.0;foreach ($nv as $nv){$nov = $nov+$nv->harga;}
	// 	$dc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'12')->get();$dec = 0.0;foreach ($dc as $dc){$dec = $dec+$dc->harga;}

	// 	$data = [
	// 		'tgl' => DB::table('tb_cart')->select(DB::raw('YEAR(created_at) tahun'))->where('id_pemasar',Auth()->user()->id)->groupby('tahun')->get(),
	// 		'bln' => DB::table('tb_cart')->select(DB::raw('MONTH(created_at) bulan'))->where('id_pemasar',Auth()->user()->id)->groupby('bulan')->get(),
	// 		'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
	// 		'bulan' => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
	// 	];
	// 	// dd($data);
	// 	return view('marketing.pendapatan.index',compact('data'));
	// }

	public function index(Request $request)
	{

			$data = [
				'tgl' => DB::table('tb_cart')->select(DB::raw('YEAR(created_at) tahun'))->where('id_pemasar',Auth()->user()->id)->groupby('tahun')->get(),
				'bln' => DB::table('tb_cart')->select(DB::raw('MONTH(created_at) bulan'))->where('id_pemasar',Auth()->user()->id)->groupby('bulan')->get(),
				'bulan' => ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]
			];
		
		
		// dd($data);
		return view('marketing.pendapatan.index',compact('data'));
	}

	public function getDataBulan(Request $request)
	{
		$tahun = $request['tahun'];
		$bulan = $request['bulan'];

		$query = DB::table('tb_cart')
			->select(DB::raw('YEAR(created_at) as tahun'), DB::raw('MONTH(created_at) as bulan'), DB::raw('DAY(created_at) as hari'), DB::raw('SUM(harga) as total_harga'))
			->where('id_pemasar', Auth()->user()->id);

		if ($tahun) {
			$query->whereYear('created_at', $tahun);
		}

		if ($bulan) {
			$query->whereMonth('created_at', $bulan);
		}

		$dataTgl = $query->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'), DB::raw('DAY(created_at)'))->get();

		$bulanTahun = Carbon::create($tahun ?? Carbon::now()->year, $bulan ?? Carbon::now()->month, 1);
		$hariDalamBulan = $bulanTahun->daysInMonth;

		$dataTanggal = [];
		for ($i = 1; $i <= $hariDalamBulan; $i++) {
			$dataTanggal[$i] = 0; // Default value 0
		}

		foreach ($dataTgl as $item) {
			$dataTanggal[$item->hari] = $item->total_harga; // Replace with actual data
		}

		$tanggal_lengkap = [];
		foreach ($dataTanggal as $hari => $value) {
			$tanggal_lengkap[] = $bulanTahun->format('Y-m-' . sprintf("%02d", $hari));
		}

		$data = [
			'tanggal_lengkap' => $tanggal_lengkap, // Array of all dates in the month
			'isi' => array_values($dataTanggal),   // Data values corresponding to the dates
		];

		return response()->json($data);

		// if (!empty($bulan)) {


		// 	if ($request->ajax()) {
		// 		return response()->json($data, 200);
		// 	}
		// } else {
			
		// }
	}
	
	public function getDataBulanCstm(Request $request)
	{
		$tahun = $request['tahun'];
		$bulan = $request['bulan'];

		$query = DB::table('tb_custom')
			->select(DB::raw('YEAR(created_at) as tahun'), DB::raw('MONTH(created_at) as bulan'), DB::raw('DAY(created_at) as hari'), DB::raw('SUM(harga) as total_harga'))
			->where('id_pemasar', Auth()->user()->id);

		if ($tahun) {
			$query->whereYear('created_at', $tahun);
		}

		if ($bulan) {
			$query->whereMonth('created_at', $bulan);
		}

		$dataTgl = $query->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'), DB::raw('DAY(created_at)'))->get();

		$bulanTahun = Carbon::create($tahun ?? Carbon::now()->year, $bulan ?? Carbon::now()->month, 1);
		$hariDalamBulan = $bulanTahun->daysInMonth;

		$dataTanggal = [];
		for ($i = 1; $i <= $hariDalamBulan; $i++) {
			$dataTanggal[$i] = 0; // Default value 0
		}

		foreach ($dataTgl as $item) {
			$dataTanggal[$item->hari] = $item->total_harga; // Replace with actual data
		}

		$tanggal_lengkap = [];
		foreach ($dataTanggal as $hari => $value) {
			$tanggal_lengkap[] = $bulanTahun->format('Y-m-' . sprintf("%02d", $hari));
		}

		$data = [
			'tanggal_lengkap' => $tanggal_lengkap, // Array of all dates in the month
			'isi' => array_values($dataTanggal),   // Data values corresponding to the dates
		];

		return response()->json($data);

		// if (!empty($bulan)) {


		// 	if ($request->ajax()) {
		// 		return response()->json($data, 200);
		// 	}
		// } else {
			
		// }
	}

	public function getDataTahun(Request $request)
	{	
		$tahun = $request['tahun'];

		if (!empty($tahun)) {
			$jn = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'01')->get();$jan = 0.0;foreach ($jn as $jn){$jan = $jan+$jn->harga;}
			$fb = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'02')->get();$feb = 0.0;foreach ($fb as $fb){$feb = $feb+$fb->harga;}
			$mr = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'03')->get();$mar = 0.0;foreach ($mr as $mr){$mar = $mar+$mr->harga;}
			$ap = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'04')->get();$apr = 0.0;foreach ($ap as $ap){$apr = $apr+$ap->harga;}
			$me = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'05')->get();$may = 0.0;foreach ($me as $me){$may = $may+$me->harga;}
			$jn = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'06')->get();$jun = 0.0;foreach ($jn as $jn){$jun = $jun+$jn->harga;}
			$ju = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'07')->get();$jul = 0.0;foreach ($ju as $ju){$jul = $jul+$ju->harga;}
			$ag = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'08')->get();$aug = 0.0;foreach ($ag as $ag){$aug = $aug+$ag->harga;}
			$sp = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'09')->get();$sep = 0.0;foreach ($sp as $sp){$sep = $sep+$sp->harga;}
			$oc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'10')->get();$oct = 0.0;foreach ($oc as $oc){$oct = $oct+$oc->harga;}
			$nv = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'11')->get();$nov = 0.0;foreach ($nv as $nv){$nov = $nov+$nv->harga;}
			$dc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'12')->get();$dec = 0.0;foreach ($dc as $dc){$dec = $dec+$dc->harga;}
			
			if ($request->ajax()) {
				return response()->json([
					'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
					'bulan' => ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des"],
				]);
			}
		} else {
			$jn = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'01')->get();$jan = 0.0;foreach ($jn as $jn){$jan = $jan+$jn->harga;}
			$fb = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'02')->get();$feb = 0.0;foreach ($fb as $fb){$feb = $feb+$fb->harga;}
			$mr = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'03')->get();$mar = 0.0;foreach ($mr as $mr){$mar = $mar+$mr->harga;}
			$ap = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'04')->get();$apr = 0.0;foreach ($ap as $ap){$apr = $apr+$ap->harga;}
			$me = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'05')->get();$may = 0.0;foreach ($me as $me){$may = $may+$me->harga;}
			$jn = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'06')->get();$jun = 0.0;foreach ($jn as $jn){$jun = $jun+$jn->harga;}
			$ju = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'07')->get();$jul = 0.0;foreach ($ju as $ju){$jul = $jul+$ju->harga;}
			$ag = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'08')->get();$aug = 0.0;foreach ($ag as $ag){$aug = $aug+$ag->harga;}
			$sp = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'09')->get();$sep = 0.0;foreach ($sp as $sp){$sep = $sep+$sp->harga;}
			$oc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'10')->get();$oct = 0.0;foreach ($oc as $oc){$oct = $oct+$oc->harga;}
			$nv = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'11')->get();$nov = 0.0;foreach ($nv as $nv){$nov = $nov+$nv->harga;}
			$dc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'12')->get();$dec = 0.0;foreach ($dc as $dc){$dec = $dec+$dc->harga;}
			
			if ($request->ajax()) {
				return response()->json([
					'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
					'bulan' => ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des"],
				]);
			}
		}

	}
	
	public function getDataTahunCstm(Request $request)
	{	
		$tahun = $request['tahun'];

		if (!empty($tahun)) {
			$jn = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'01')->get();$jan = 0.0;foreach ($jn as $jn){$jan = $jan+$jn->harga;}
			$fb = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'02')->get();$feb = 0.0;foreach ($fb as $fb){$feb = $feb+$fb->harga;}
			$mr = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'03')->get();$mar = 0.0;foreach ($mr as $mr){$mar = $mar+$mr->harga;}
			$ap = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'04')->get();$apr = 0.0;foreach ($ap as $ap){$apr = $apr+$ap->harga;}
			$me = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'05')->get();$may = 0.0;foreach ($me as $me){$may = $may+$me->harga;}
			$jn = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'06')->get();$jun = 0.0;foreach ($jn as $jn){$jun = $jun+$jn->harga;}
			$ju = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'07')->get();$jul = 0.0;foreach ($ju as $ju){$jul = $jul+$ju->harga;}
			$ag = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'08')->get();$aug = 0.0;foreach ($ag as $ag){$aug = $aug+$ag->harga;}
			$sp = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'09')->get();$sep = 0.0;foreach ($sp as $sp){$sep = $sep+$sp->harga;}
			$oc = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'10')->get();$oct = 0.0;foreach ($oc as $oc){$oct = $oct+$oc->harga;}
			$nv = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'11')->get();$nov = 0.0;foreach ($nv as $nv){$nov = $nov+$nv->harga;}
			$dc = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),$tahun)->where(DB::raw('MONTH(created_at)'),'12')->get();$dec = 0.0;foreach ($dc as $dc){$dec = $dec+$dc->harga;}
			
			if ($request->ajax()) {
				return response()->json([
					'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
					'bulan' => ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des"],
				]);
			}
		} else {
			$jn = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'01')->get();$jan = 0.0;foreach ($jn as $jn){$jan = $jan+$jn->harga;}
			$fb = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'02')->get();$feb = 0.0;foreach ($fb as $fb){$feb = $feb+$fb->harga;}
			$mr = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'03')->get();$mar = 0.0;foreach ($mr as $mr){$mar = $mar+$mr->harga;}
			$ap = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'04')->get();$apr = 0.0;foreach ($ap as $ap){$apr = $apr+$ap->harga;}
			$me = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'05')->get();$may = 0.0;foreach ($me as $me){$may = $may+$me->harga;}
			$jn = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'06')->get();$jun = 0.0;foreach ($jn as $jn){$jun = $jun+$jn->harga;}
			$ju = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'07')->get();$jul = 0.0;foreach ($ju as $ju){$jul = $jul+$ju->harga;}
			$ag = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'08')->get();$aug = 0.0;foreach ($ag as $ag){$aug = $aug+$ag->harga;}
			$sp = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'09')->get();$sep = 0.0;foreach ($sp as $sp){$sep = $sep+$sp->harga;}
			$oc = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'10')->get();$oct = 0.0;foreach ($oc as $oc){$oct = $oct+$oc->harga;}
			$nv = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'11')->get();$nov = 0.0;foreach ($nv as $nv){$nov = $nov+$nv->harga;}
			$dc = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),DATE('Y'))->where(DB::raw('MONTH(created_at)'),'12')->get();$dec = 0.0;foreach ($dc as $dc){$dec = $dec+$dc->harga;}
			
			if ($request->ajax()) {
				return response()->json([
					'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
					'bulan' => ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des"],
				]);
			}
		}

	}

	public function cstm()
	{
		$data = [
			'tgl' => DB::table('tb_custom')->select(DB::raw('YEAR(created_at) tahun'))->where('id_pemasar',Auth()->user()->id)->groupby('tahun')->get(),
			'bulan' => ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]
		];
		// dd($data);
		return view('marketing.pendapatan.index_c',compact('data'));
	}

	public function get_data_pmsn(Request $request)
	{
		$tahun = $request['tahun'];
		$bulan = $request['bulan'];

		$limit = is_null($request["length"]) ? 10 : $request["length"];
		$offset = is_null($request["start"]) ? 0 : $request["start"];
		$draw = $request["draw"];
		$search = $request->search['value'];

		$data = [];
		$result = DB::table('tb_cart as a')
			->select(
				'a.id_pemasar',
				'a.id',
				'b.nama',
				'c.name',
				'b.gambar',
				'a.harga',
				'a.created_at',
				'a.status'
			)
			->leftJoin('tb_gambar as b', 'a.id_gambar', 'b.id')
			->leftJoin('users as c', 'a.id_cust', 'c.id')
			->whereYear('a.created_at', $tahun)
			->whereMonth('a.created_at', $bulan)
			->where('a.id_pemasar', '=', Auth()->user()->id);

		if (!empty($search)) {
			$result = $result->where(function($query) use ($search) {
				$query->where('a.id', 'LIKE', '%' . $search . '%')
					->orWhere('b.nama', 'LIKE', '%' . $search . '%')
					->orWhere('c.name', 'LIKE', '%' . $search . '%')
					->orWhere('b.gambar', 'LIKE', '%' . $search . '%')
					->orWhere('a.harga', 'LIKE', '%' . $search . '%')
					->orWhere('a.created_at', 'LIKE', '%' . $search . '%')
					->orWhere('a.status', 'LIKE', '%' . $search . '%');
			});
		}

		$get_count = $result->count();
		$result = $result
			->limit($limit)
			->offset($offset)
			->get();

		foreach ($result as $key => $value) {
			$data[] = array(
				'id' => $value->id,
				'nama_gambar' => $value->nama,
				'gambar' => $value->gambar,
				'pemesan' => $value->name,
				'harga' => $value->harga,
				'pesan' => $value->created_at,
				'bayar' => $value->status,
			);
		}

		$recordsTotal = is_null($get_count) ? 0 : $get_count;
		$recordsFiltered = is_null($get_count) ? 0 : $get_count;

		if ($request->ajax()) {
			return response()->json([
				'data' => $data,
				'draw' => $draw,
				'recordsTotal' => $recordsTotal,
				'recordsFiltered' => $recordsFiltered,
			]);
		}
	}

	public function get_grafik_pmsn()
	{	
		$jn = DB::table('tb_cart')
		->select(DB::raw('harga'),)
		->where('id_pemasar','=',Auth()->user()->id)
		->where(DB::raw('YEAR(created_at)'),request()->tahun)
		->where(DB::raw('MONTH(created_at)'),'01')
		->get();
		$jan = 0.0;
		foreach ($jn as $jn){$jan = $jan+$jn->harga;}
		$fb = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'02')->get();$feb = 0.0;foreach ($fb as $fb){$feb = $feb+$fb->harga;}
		$mr = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'03')->get();$mar = 0.0;foreach ($mr as $mr){$mar = $mar+$mr->harga;}
		$ap = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'04')->get();$apr = 0.0;foreach ($ap as $ap){$apr = $apr+$ap->harga;}
		$me = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'05')->get();$may = 0.0;foreach ($me as $me){$may = $may+$me->harga;}
		$jn = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'06')->get();$jun = 0.0;foreach ($jn as $jn){$jun = $jun+$jn->harga;}
		$ju = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'07')->get();$jul = 0.0;foreach ($ju as $ju){$jul = $jul+$ju->harga;}
		$ag = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'08')->get();$aug = 0.0;foreach ($ag as $ag){$aug = $aug+$ag->harga;}
		$sp = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'09')->get();$sep = 0.0;foreach ($sp as $sp){$sep = $sep+$sp->harga;}
		$oc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'10')->get();$oct = 0.0;foreach ($oc as $oc){$oct = $oct+$oc->harga;}
		$nv = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'11')->get();$nov = 0.0;foreach ($nv as $nv){$nov = $nov+$nv->harga;}
		$dc = DB::table('tb_cart')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'12')->get();$dec = 0.0;foreach ($dc as $dc){$dec = $dec+$dc->harga;}

		$data = [
			'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
			'bulan' => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
		];
		// return request()->tahun;
		return $data;
	}
	public function get_grafik_cstm()
	{	
		$jn = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'01')->get();$jan = 0.0;foreach ($jn as $jn){$jan = $jan+$jn->harga;}
		$fb = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'02')->get();$feb = 0.0;foreach ($fb as $fb){$feb = $feb+$fb->harga;}
		$mr = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'03')->get();$mar = 0.0;foreach ($mr as $mr){$mar = $mar+$mr->harga;}
		$ap = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'04')->get();$apr = 0.0;foreach ($ap as $ap){$apr = $apr+$ap->harga;}
		$me = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'05')->get();$may = 0.0;foreach ($me as $me){$may = $may+$me->harga;}
		$jn = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'06')->get();$jun = 0.0;foreach ($jn as $jn){$jun = $jun+$jn->harga;}
		$ju = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'07')->get();$jul = 0.0;foreach ($ju as $ju){$jul = $jul+$ju->harga;}
		$ag = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'08')->get();$aug = 0.0;foreach ($ag as $ag){$aug = $aug+$ag->harga;}
		$sp = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'09')->get();$sep = 0.0;foreach ($sp as $sp){$sep = $sep+$sp->harga;}
		$oc = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'10')->get();$oct = 0.0;foreach ($oc as $oc){$oct = $oct+$oc->harga;}
		$nv = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'11')->get();$nov = 0.0;foreach ($nv as $nv){$nov = $nov+$nv->harga;}
		$dc = DB::table('tb_custom')->select(DB::raw('harga'),)->where('id_pemasar','=',Auth()->user()->id)->where(DB::raw('YEAR(created_at)'),request()->tahun)->where(DB::raw('MONTH(created_at)'),'12')->get();$dec = 0.0;foreach ($dc as $dc){$dec = $dec+$dc->harga;}

		$data = [
			'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
			'bulan' => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
		];
		// return request()->tahun;
		return $data;
	}

	public function get_data_cstm(Request $request)
	{
		$tahun = $request['tahun'];
		$bulan = $request['bulan'];

		$limit = is_null($request["length"]) ? 10 : $request["length"];
		$offset = is_null($request["start"]) ? 0 : $request["start"];
		$draw = $request["draw"];
		$search = $request->search['value'];

		$data = [];
		$result = DB::table('tb_custom as a')
			->select(
				'a.id_pemasar',
				'a.id',
				'a.nama',
				'c.name',
				'a.sampel',
				'a.harga',
				'a.created_at',
				'a.status'
			)
			->leftJoin('users as c', 'a.id_cust', 'c.id')
			->whereYear('a.created_at', $tahun)
			->whereMonth('a.created_at', $bulan)
			->where('id_pemasar', '=', Auth()->user()->id);

		if (!empty($search)) {
			$result = $result->where(function($query) use ($search) {
				$query->where('a.id', 'LIKE', '%' . $search . '%')
					->orWhere('a.nama', 'LIKE', '%' . $search . '%')
					->orWhere('c.name', 'LIKE', '%' . $search . '%')
					->orWhere('a.sampel', 'LIKE', '%' . $search . '%')
					->orWhere('a.harga', 'LIKE', '%' . $search . '%')
					->orWhere('a.created_at', 'LIKE', '%' . $search . '%')
					->orWhere('a.status', 'LIKE', '%' . $search . '%');
			});
		}

		$get_count = $result->count();
		$result = $result
			->limit($limit)
			->offset($offset)
			->get();

		foreach ($result as $key => $value) {
			$data[] = array(
				'id' => $value->id,
				'nama_gambar' => $value->nama,
				'gambar' => $value->sampel,
				'pemesan' => $value->name,
				'harga' => $value->harga,
				'pesan' => $value->created_at,
				'bayar' => $value->status,
			);
		}

		$recordsTotal = is_null($get_count) ? 0 : $get_count;
		$recordsFiltered = is_null($get_count) ? 0 : $get_count;

		if ($request->ajax()) {
			return response()->json([
				'data' => $data,
				'draw' => $draw,
				'recordsTotal' => $recordsTotal,
				'recordsFiltered' => $recordsFiltered,
			]);
		}
	}

	public function d_pmsn()
	{	
		$data = db::table('tb_cart')->where('id_pemasar',Auth()->user()->id)->where('status','dibayar')->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}
	public function b_pmsn()
	{	
		$data = db::table('tb_cart')->where('id_pemasar',Auth()->user()->id)->where('status','pesan')->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}
	public function t_pmsn(Request $request)
	{	
		$tahun = $request['tahun'];

		$data = db::table('tb_cart')->whereYear('created_at', $tahun)->where('id_pemasar',Auth()->user()->id)->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}
	
	public function totalHargaBulan(Request $request)
	{	
		$tahun = $request['tahun'];
		$bulan = $request['bulan'];

		$data = db::table('tb_cart')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->where('id_pemasar',Auth()->user()->id)->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}
	
	public function totalHargaBulanCstm(Request $request)
	{	
		$tahun = $request['tahun'];
		$bulan = $request['bulan'];

		$data = db::table('tb_custom')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->where('id_pemasar',Auth()->user()->id)->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}

	public function d_cstm()
	{	
		$data = db::table('tb_custom')->where('id_pemasar',Auth()->user()->id)->where('status','dibayar')->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}
	public function b_cstm()
	{	
		$data = db::table('tb_custom')->where('id_pemasar',Auth()->user()->id)->where('status','pesan')->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}
	public function t_cstm(Request $request)
	{	
		$tahun = $request['tahun'];

		$data = db::table('tb_custom')->whereYear('created_at', $tahun)->where('id_pemasar',Auth()->user()->id)->get();
		$x = 0;
		foreach ($data as $key => $value) {
			$x=$x+$value->harga;
		}
		return response()->json($x,200);
	}

	public function load_ratting(){
		$get = db::table('tb_custom')->where('id',request()->id)->first();
		return response()->json($get->rate,200);
	}

	public function load_comment(){
		$get = db::table('tb_custom')->where('id',request()->id)->first();
		return response()->json($get->koment,200);
	}
}
