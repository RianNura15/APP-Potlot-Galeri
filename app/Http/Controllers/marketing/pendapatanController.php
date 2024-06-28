<?php

namespace App\Http\Controllers\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB, Response, Auth;

class pendapatanController extends Controller
{
	public function index()
	{
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

		$data = [
			'tgl' => DB::table('tb_cart')->select(DB::raw('YEAR(created_at) tahun'))->where('id_pemasar',Auth()->user()->id)->groupby('tahun')->get(),
			'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
			'bulan' => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
		];
		// dd($data);
		return view('marketing.pendapatan.index',compact('data'));
	}

	public function cstm()
	{
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

		$data = [
			'tgl' => DB::table('tb_custom')->select(DB::raw('YEAR(created_at) tahun'))->where('id_pemasar',Auth()->user()->id)->groupby('tahun')->get(),
			'isi' => [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec],
			'bulan' => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
		];
		// dd($data);
		return view('marketing.pendapatan.index_c',compact('data'));
	}

	public function get_data_pmsn(Request $request)
	{
		// dd('ok');
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
		->leftjoin('tb_gambar as b','a.id_gambar','b.id')
		->leftjoin('users as c','a.id_cust','c.id')
		->where('a.id_pemasar','=',Auth()->user()->id)
		;

		if (!empty($search)) {

			$result = $result
			->where('a.id','LIKE','%'.$search.'%')
			->orwhere('b.nama','LIKE','%'.$search.'%')
			->orwhere('c.name','LIKE','%'.$search.'%')
			->orwhere('b.gambar','LIKE','%'.$search.'%')
			->orwhere('a.harga','LIKE','%'.$search.'%')
			->orwhere('a.created_at','LIKE','%'.$search.'%')
			->orwhere('a.status','LIKE','%'.$search.'%')
			->where('a.id_pemasar',Auth()->user()->id)
			;
		}

		$get_count = $result->get()->count();
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
		// dd($data);
		$recordsTotal = is_null($get_count) ? 0 : $get_count;
		$recordsFiltered = is_null($get_count) ? 0 : $get_count;
		return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
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
		// dd('ok');
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
			'a.sampel',
			'b.name',
			'a.harga',
			'a.created_at',
			'a.status',
		)
		->leftjoin('users as b','a.id_cust','b.id')
		->where('id_pemasar',Auth()->user()->id)
		;

		$get_count = $result->get()->count();
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

		// dd($data);
		$recordsTotal = is_null($get_count) ? 0 : $get_count;
		$recordsFiltered = is_null($get_count) ? 0 : $get_count;
		return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
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
	public function t_pmsn()
	{	
		$data = db::table('tb_cart')->where('id_pemasar',Auth()->user()->id)->get();
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
	public function t_cstm()
	{	
		$data = db::table('tb_custom')->where('id_pemasar',Auth()->user()->id)->get();
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
