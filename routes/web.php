<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('blog.dashboard');
});

Route::get('/dashboard', function () {
  return view('blog.dashboard2');
});

Route::post('/ceklogin', 'Auth\LoginBaruController@login')->name('ceklogin');
Route::get('logoutlagi', 'Auth\LoginController@logoutbaru');

Route::get('/login2', function () {
  return view('auth.login2');
});

Route::get('test_gambar/{gambar}','TestController@index')->name('test_gambar');
Route::get('verif_akun/{email}', 'TestController@show')->name('veriCust');

Route::get('resize_gambar/{gambar}',function($gambar){
  $path = public_path('images/'.$gambar);
  $image = Image::make($path)->resize(200,null,function($data){
    $data->aspectRatio();
  });
  return $image->response();
})->name('resize_gambar');
Route::get('download/{gambar}',function($gambar){
  $path = public_path('images/'.$gambar);
  return Response::download($path);
})->name('download');

Auth::routes();

Route::post('customer','Auth\DaftarController@customer')->name('customer');
Route::post('marketing','Auth\DaftarController@marketing')->name('marketing');

Route::namespace('pemilik')->prefix('pemilik')->name('pemilik.')->middleware('checkrole:pemilik')->group(function(){
  Route::get('home', 'HomeController@index')->name('home');
  Route::get('home/detail/{id}', 'HomeController@detail')->name('detail');
  Route::get('home/detail/gaji/{id}', 'HomeController@gaji')->name('gaji');
  Route::get('home/detail/delete/{id}/delete/{tgl}', 'HomeController@delete')->name('delete');
  Route::patch('home/detail/ubah/{id}/ubah/{tgl}', 'HomeController@ubah')->name('ubah');

  Route::prefix('user')->name('user.')->group(function(){
    Route::get('anggota','userController@anggota_index')->name('anggota');
    Route::post('add_anggota','userController@add_anggota')->name('add_anggota');
    Route::get('get_anggota','userController@get_anggota')->name('get_anggota');
    Route::post('verif_anggota','userController@verif_anggota')->name('verif_anggota');
    Route::post('delete_anggota','userController@delete_anggota')->name('delete_anggota');
    Route::get('detail_anggota','userController@detail_anggota')->name('detail_anggota');
    Route::post('edit','userController@edit')->name('edit');
  });

  Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('admin_index','userController@admin_index')->name('admin_index');
    Route::get('get_admin','userController@get_admin')->name('get_admin');
    Route::post('add_admin','userController@add_admin')->name('add_admin');
  });

  Route::prefix('customer')->name('customer.')->group(function(){
    Route::get('customer_index','userController@customer_index')->name('customer_index');
    Route::get('get_customer','userController@get_customer')->name('get_customer');
  });

  Route::prefix('pembayaran')->name('pembayaran.')->group(function(){
    Route::get('index','pembayaranController@index')->name('index');
    Route::get('index/{id}','pembayaranController@detail')->name('detail');
    Route::get('index/cetak/{id}','pembayaranController@cetak')->name('cetak');
    Route::get('get_data','pembayaranController@get_data')->name('get_data');
    Route::get('custom','pembayaranController@custom')->name('custom');
    Route::get('custom/{id}','pembayaranController@detail_c')->name('detail_c');
    Route::get('custom/cetak/{id}','pembayaranController@cetak_c')->name('cetak_c');
    Route::get('get_data_custom','pembayaranController@get_data_custom')->name('get_data_custom');
  });

  Route::prefix('karya')->name('karya.')->group(function(){
    Route::get('index','karyaController@index')->name('index');
    Route::get('get_data','karyaController@get_data')->name('get_data');
    Route::get('tambah_index','karyaController@tambah_index')->name('tambah_index');
    Route::post('tambah','karyaController@tambah')->name('tambah');
    Route::post('delete','karyaController@delete')->name('delete');
    Route::post('tambah_pemasar','karyaController@tambah_pemasar')->name('tambah_pemasar');
    Route::get('data_karya','karyaController@data_karya')->name('data_karya');
  }); 

  Route::prefix('promo')->name('promo.')->group(function(){
    Route::get('index','promoController@index')->name('index');
    Route::post('add_promo','promoController@add_promo')->name('add_promo');
  }); 

  Route::prefix('anggota')->name('anggota.')->group(function(){
    Route::get('get_json','anggotaController@get_json')->name('get_json');
  });
});

Route::namespace('admin')->prefix('admin')->name('admin.')->middleware('checkrole:admin')->group(function(){
  Route::get('home', 'HomeController@index')->name('home');

  Route::prefix('user')->name('user.')->group(function(){
    Route::get('anggota','userController@anggota_index')->name('anggota');
    Route::post('add_anggota','userController@add_anggota')->name('add_anggota');
    Route::get('get_anggota','userController@get_anggota')->name('get_anggota');
    Route::post('verif_anggota','userController@verif_anggota')->name('verif_anggota');
    Route::post('delete_anggota','userController@delete_anggota')->name('delete_anggota');
    Route::post('generate_koderef','userController@generate_koderef')->name('generate_koderef');
    Route::get('detail_anggota','userController@detail_anggota')->name('detail_anggota');
    Route::post('edit','userController@edit')->name('edit');
  });

  Route::prefix('customer')->name('customer.')->group(function(){
    Route::get('customer_index','userController@customer_index')->name('customer_index');
    Route::get('get_customer','userController@get_customer')->name('get_customer');
  });

  Route::prefix('pembayaran')->name('pembayaran.')->group(function(){
    Route::get('index','pembayaranController@index')->name('index');
    Route::get('index/{id}','pembayaranController@detail')->name('detail');
    Route::get('index/cetak/{id}','pembayaranController@cetak')->name('cetak');
    Route::get('get_data','pembayaranController@get_data')->name('get_data');
    Route::get('custom','pembayaranController@custom')->name('custom');
    Route::get('custom/{id}','pembayaranController@detail_c')->name('detail_c');
    Route::get('custom/cetak/{id}','pembayaranController@cetak_c')->name('cetak_c');
    Route::get('get_data_custom','pembayaranController@get_data_custom')->name('get_data_custom');
  });

  Route::prefix('karya')->name('karya.')->group(function(){
    Route::get('index','karyaController@index')->name('index');
    Route::get('get_data','karyaController@get_data')->name('get_data');
    Route::get('tambah_index','karyaController@tambah_index')->name('tambah_index');
    Route::post('tambah','karyaController@tambah')->name('tambah');
    Route::post('delete','karyaController@delete')->name('delete');
    Route::post('tambah_pemasar','karyaController@tambah_pemasar')->name('tambah_pemasar');
    Route::get('data_karya','karyaController@data_karya')->name('data_karya');
  }); 

  Route::prefix('promo')->name('promo.')->group(function(){
    Route::get('index','promoController@index')->name('index');
    Route::post('add_promo','promoController@add_promo')->name('add_promo');
  }); 

  Route::prefix('anggota')->name('anggota.')->group(function(){
    Route::get('get_json','anggotaController@get_json')->name('get_json');
  });

});

Route::namespace('marketing')->prefix('marketing')->name('marketing.')->middleware('checkrole:anggota')->group(function(){
  Route::get('home','dashboardController@home')->name('home');

  Route::prefix('gambar')->name('gambar.')->group(function(){
    Route::get('index','gambarController@index')->name('index');
    Route::get('tambah_index','gambarController@tambah_index')->name('tambah_index');
    Route::get('index_promo','gambarController@index_promo')->name('index_promo');
    Route::post('add_promo','gambarController@add_promo')->name('add_promo');
    Route::get('get_promo','gambarController@get_promo')->name('get_promo');
    Route::get('get_data','gambarController@get_data')->name('get_data');
    Route::post('tambah','gambarController@tambah')->name('tambah');
    Route::get('data_karya','gambarController@data_karya')->name('data_karya');
  });

  Route::prefix('transaksi')->name('transaksi.')->group(function(){
    Route::get('pesan','transaksiController@pesan')->name('pesan');
    Route::get('custom','transaksiController@custom')->name('custom');
    Route::get('chat/{id}','transaksiController@chat')->name('chat');
    Route::post('p_chat','transaksiController@p_chat')->name('p_chat');
    Route::get('get_chat','transaksiController@get_chat')->name('get_chat');
    Route::get('p_harga','transaksiController@p_harga')->name('p_harga');
    Route::get('get_harga','transaksiController@get_harga')->name('get_harga');
    Route::get('get_bayar','transaksiController@get_bayar')->name('get_bayar');
    Route::post('chat/{id}','transaksiController@lukis1')->name('lukis11');
    Route::post('lukis1','transaksiController@lukis1')->name('lukis1');
    Route::post('lukis2','transaksiController@lukis2')->name('lukis2');
    Route::post('lukis3','transaksiController@lukis3')->name('lukis3');
    Route::post('lukis4','transaksiController@lukis4')->name('lukis4');
  //   Route::get('get_data','transaksiController@get_data')->name('get_data');
  //   Route::post('verifikasi','transaksiController@verifikasi')->name('verifikasi');

    Route::get('load_ratting','pendapatanController@load_ratting')->name('load_ratting');
    Route::get('load_comment','pendapatanController@load_comment')->name('load_comment');
  });

  Route::prefix('pendapatan')->name('pendapatan.')->group(function(){
    Route::get('','pendapatanController@index')->name('index');
    Route::get('get_data_pmsn','pendapatanController@get_data_pmsn')->name('get_data_pmsn');
    Route::get('d_pmsn','pendapatanController@d_pmsn')->name('d_pmsn');
    Route::get('b_pmsn','pendapatanController@b_pmsn')->name('b_pmsn');
    Route::get('t_pmsn','pendapatanController@t_pmsn')->name('t_pmsn');
    Route::get('get_grafik_pmsn','pendapatanController@get_grafik_pmsn')->name('get_grafik_pmsn');
    
    Route::get('cstm','pendapatanController@cstm')->name('cstm');
    Route::get('get_data_cstm','pendapatanController@get_data_cstm')->name('get_data_cstm');
    Route::get('d_cstm','pendapatanController@d_cstm')->name('d_cstm');
    Route::get('b_cstm','pendapatanController@b_cstm')->name('b_cstm');
    Route::get('t_cstm','pendapatanController@t_cstm')->name('t_cstm');
    Route::get('get_grafik_cstm','pendapatanController@get_grafik_cstm')->name('get_grafik_cstm');
  });
});

Route::namespace('blog')->prefix('blog')->name('blog.')->group(function(){
  Route::get('index','dashboardController@index')->name('index');
  Route::get('lukisan_json','lukisanController@lukisan_json')->name('lukisan_json');

  Route::prefix('lukisan')->name('lukisan.')->group(function(){
    Route::get('detail','lukisanController@detail')->name('detail');
  });

  Route::prefix('keranjang')->name('keranjang.')->group(function(){
    Route::get('index','keranjangController@index')->name('index');
    Route::post('tambah','keranjangController@tambah')->name('tambah');
    Route::get('cart_id','keranjangController@cart_id')->name('cart_id');
    Route::post('batal','keranjangController@batal')->name('batal');

  });

  Route::prefix('order')->name('order.')->group(function(){
    Route::post('bayar','orderController@bayar')->name('bayar');
    Route::get('payload','orderController@payload')->name('payload');
    Route::post('status','orderController@status')->name('status');
  });

  Route::prefix('custom')->name('custom.')->group(function(){
    Route::get('cart_id','customController@cart_id')->name('cart_id');
    Route::post('bayar','customController@bayar')->name('bayar');
    Route::post('ratting','customController@ratting')->name('ratting');
    Route::get('load_ratting','customController@load_ratting')->name('load_ratting');
    Route::post('comment','customController@comment')->name('comment');
    Route::get('load_comment','customController@load_comment')->name('load_comment');
    Route::get('payload','customController@payload')->name('payload');
    Route::post('status','customController@status')->name('status');


    Route::get('index','customController@index')->name('index');
    Route::get('tambah','customController@tambah')->name('tambah');
    Route::post('create','customController@create')->name('create');
    Route::get('chat/{id}','customController@chat')->name('chat');
    Route::get('cetak/{id}','customController@cetak')->name('cetak');
    Route::post('p_chat','customController@p_chat')->name('p_chat');
    Route::get('get_chat','customController@get_chat')->name('get_chat');
    Route::get('get_harga','customController@get_harga')->name('get_harga');
    Route::get('get_bayar','customController@get_bayar')->name('get_bayar');
    Route::get('get_gb','customController@get_gb')->name('get_gb');
    Route::get('get_d','customController@get_d')->name('get_d');
    Route::get('data_list','customController@data_list')->name('data_list');

  });
});


// Route::namespace('admin')->prefix('admin')->name('admin.')->middleware('checkrole:admin')->group(function(){
//   Route::get('home', 'HomeController@index')->name('home');
//   Route::prefix('user')->name('user.')->group(function(){
//     Route::get('anggota','userController@anggota_index')->name('anggota');
//     Route::post('add_anggota','userController@add_anggota')->name('add_anggota');
//     Route::get('get_anggota','userController@get_anggota')->name('get_anggota');
//     Route::post('verif_anggota','userController@verif_anggota')->name('verif_anggota');
//     Route::post('delete_anggota','userController@delete_anggota')->name('delete_anggota');
//     Route::get('detail_anggota','userController@detail_anggota')->name('detail_anggota');
//     Route::post('edit','userController@edit')->name('edit');

//     Route::get('get_pelukis','userController@get_pelukis')->name('get_pelukis');
//     Route::post('add_pelukis','userController@add_pelukis')->name('add_pelukis');
//   });
//   Route::prefix('customer')->name('customer.')->group(function(){
//     Route::get('customer_index','userController@customer_index')->name('customer_index');
//     Route::get('get_customer','userController@get_customer')->name('get_customer');
//   });
//   Route::prefix('karya')->name('karya.')->group(function(){
//     Route::get('index','karyaController@index')->name('index');
//     Route::get('get_data','karyaController@get_data')->name('get_data');
//     Route::get('tambah_index','karyaController@tambah_index')->name('tambah_index');
//     Route::post('tambah','karyaController@tambah')->name('tambah');
//     Route::post('delete','karyaController@delete')->name('delete');
//     Route::post('tambah_pemasar','karyaController@tambah_pemasar')->name('tambah_pemasar');
//     Route::get('data_karya','karyaController@data_karya')->name('data_karya');
//   });
//   Route::prefix('pelukis')->name('pelukis.')->group(function(){
//     Route::get('index','pelukisController@index')->name('index');
//   });
//   Route::prefix('promo')->name('promo.')->group(function(){
//     Route::get('index','promoController@index')->name('index');
//     Route::post('add_promo','promoController@add_promo')->name('add_promo');
//   });
//   Route::prefix('anggota')->name('anggota.')->group(function(){
//     Route::get('get_json','anggotaController@get_json')->name('get_json');
//   });
//   Route::prefix('pembayaran')->name('pembayaran.')->group(function(){
//     Route::get('index','pembayaranController@index')->name('index');
//     Route::get('get_data','pembayaranController@get_data')->name('get_data');
// //   });
//   });

//   Route::namespace('blog')->prefix('blog')->name('blog.')->group(function(){
//     Route::get('index','dashboardController@index')->name('index');
//     Route::get('lukisan_json','lukisanController@lukisan_json')->name('lukisan_json');
//     Route::prefix('lukisan')->name('lukisan.')->group(function(){
//       Route::get('detail','lukisanController@detail')->name('detail');
//     });

//     Route::prefix('keranjang')->name('keranjang.')->group(function(){
//       Route::get('index','keranjangController@index')->name('index');
//       Route::post('tambah','keranjangController@tambah')->name('tambah');
//       Route::post('batal','keranjangController@batal')->name('batal');
//       Route::get('cart_id','keranjangController@cart_id')->name('cart_id');
//     });
//     Route::prefix('order')->name('order.')->group(function(){
//       Route::post('bayar','orderController@bayar')->name('bayar');
//       Route::get('payload','orderController@payload')->name('payload');
//       Route::post('status','orderController@status')->name('status');
// //   });

//       Route::prefix('custom')->name('custom.')->group(function(){
//         Route::get('index','customController@index')->name('index');
//         Route::post('create','customController@create')->name('create');
//         Route::get('data_list','customController@data_list')->name('data_list');
//         Route::post('batal','customController@batal')->name('batal');
//       });
//     });

//     Route::namespace('pelukis')->prefix('pelukis')->name('pelukis.')->middleware('checkrole:pelukis')->group(function(){
//       Route::get('home','dahsboardController@home')->name('home');

//       Route::prefix('karya')->name('karya.')->group(function(){
//         Route::get('index','karyaController@index')->name('index');
//         Route::get('get_data','karyaController@get_data')->name('get_data');
//         Route::get('tambah_index','karyaController@tambah_index')->name('tambah_index');
//         Route::post('tambah','karyaController@tambah')->name('tambah');
//         Route::post('hapus','karyaController@hapus')->name('hapus');
//       });
//       Route::prefix('komisi')->name('komisi')->group(function(){
//         Route::get('index','komisiController@index')->name('index');
//       });
//     });

//     Route::namespace('pemilik')->prefix('pemilik')->name('pemilik.')->middleware('checkrole:pemilik')->group(function(){
//       Route::get('index','HomeController@index')->name('index');
//       Route::prefix('akun')->name('akun.')->group(function(){
//         Route::get('admin','akunController@admin')->name('admin');
//         Route::get('anggota','akunController@anggota')->name('anggota');
//         Route::get('customer','akunController@customer')->name('customer');

//         Route::get('get_data_admin','akunController@get_data_admin')->name('get_data_admin');
//         Route::post('insert_admin','akunController@insert_admin')->name('insert_admin');
//         Route::get('show','akunController@show')->name('show');
//         Route::post('update','akunController@update')->name('update');
//         Route::post('hapus','akunController@hapus')->name('hapus');
//       });

//       Route::prefix('transaksi')->name('transaksi.')->group(function(){
//         Route::get('index','transaksiController@index')->name('index');
//         Route::get('get_data','transaksiController@get_data')->name('get_data');
//       });

//       Route::prefix('custom')->name('custom.')->group(function(){
//         Route::get('index','customController@index')->name('index');
//         Route::get('get_data','customController@get_data')->name('get_data');

//       });
//     });

//     Route::namespace('marketing')->prefix('marketing')->name('marketing.')->middleware('checkrole:anggota')->group(function(){
//       Route::get('home','dashboardController@home')->name('home');

//       Route::prefix('gambar')->name('gambar.')->group(function(){
//         Route::get('index','gambarController@index')->name('index');
//         Route::get('tambah_index','gambarController@tambah_index')->name('tambah_index');
//         Route::get('index_promo','gambarController@index_promo')->name('index_promo');
//         Route::post('add_promo','gambarController@add_promo')->name('add_promo');
//         Route::get('get_promo','gambarController@get_promo')->name('get_promo');
//         Route::get('get_data','gambarController@get_data')->name('get_data');
//         Route::post('tambah','gambarController@tambah')->name('tambah');
//         Route::get('data_karya','gambarController@data_karya')->name('data_karya');
//       });

//       Route::prefix('transaksi')->name('transaksi.')->group(function(){
//         Route::get('index','transaksiController@index')->name('index');
//         Route::get('get_data','transaksiController@get_data')->name('get_data');
//         Route::post('verifikasi','transaksiController@verifikasi')->name('verifikasi');
//       });
//     });
