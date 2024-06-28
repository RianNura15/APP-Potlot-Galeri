@extends('layouts.blog.app')

@push('styleshet')
<style type="text/css">
	.scrollable{
		position: relative;
	}

	.pre-scrollable {
		max-height: 340px;
		overflow-y: scroll; 
	}

	.scrollable-dropdown {
		max-height: 80px;
		overflow-y: auto; 
	}
</style>
@endpush

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 card">
			<div class="card-header">
				Hasil Lukisan
			</div>
			<div class="card-body" id="gb1">
			</div>
			<div class="card-footer" id="d1">
			</div>
		</div>
		<div class="col-md-3 card">
			<div class="card-header">
				Hasil Perbaikan 1
			</div>
			<div class="card-body" id="gb2">
			</div>
			<div class="card-footer" id="d2">
			</div>
		</div>
        <div class="col-md-3 card">
			<div class="card-header">
            Hasil Perbaikan 2
			</div>
			<div class="card-body" id="gb3">
			</div>
			<div class="card-footer" id="d3">
			</div>
		</div>

		<div class="col-md-3 card">
			<div class="card-header">
            Hasil Perbaikan 3
			</div>
			<div class="card-body" id="gb4">
			</div>
			<div class="card-footer" id="d4">
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-2">
	<div class="row">
		<div class="col-md-3 card">
			<div class="card-header">
				Sampel Lukisan
			</div>
			<div class="card-body">
				<img class="img-fluid img-thumbnail" src="{{asset('public\custom')}}\{{$data['custom']->sampel}}" alt="">
                <br>
                <table class="table-sm">
                    <tr>
                        <td colspan="3">Ratting Bintang <span id="hsratting" colspan="3"></span></td>
                    </tr>
                    <tr id="dratting">
                        <td contenteditable="true">
                            <select class="ratting form-control" id="ratting">
                                <option value="1" id="r1">1</option>
                                <option value="2" id="r2">2</option>
                                <option value="3" id="r3">3</option>
                                <option value="4" id="r4">4</option>
                                <option value="5" id="r5">5</option>
                            </select>
                        </td>
                        <td>:</td>
                        <td>
                            <button class="btn btn-success btn-sm"  onclick="simpan()">Simpan</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <table class="table-sm">
                    <tr>
                        <td>Marketing</td><td>:</td><td><span class="justify-content-center" id="marketing">{{App\User::nama_pemasar($data['custom']->id_pemasar)}}</span></td>
                    </tr>
                    <tr>
                        <td>Nama</td><td>:</td><td><span class="justify-content-center" id="nama">{{$data['custom']->nama}}</span></td>
                    </tr>
                    <tr>
                        <td>Harga</td><td>:</td><td><span class="justify-content-center" id="harg"></span></td>
                    </tr>
                    <tr>
                        <td>Ukuran</td>
                        <td>:</td>
                        <td>
                            <span class="justify-content-center">
                                @if($data['custom']->canvas==46)
                                40 X 60
                                @elseif($data['custom']->canvas==67)
                                60 X 70
                                @elseif($data['custom']->canvas==79)
                                70 X 90
                                @elseif($data['custom']->canvas==912)
                                90 X 120
                                @elseif($data['custom']->canvas==1218)
                                120 X 180
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Media</td>
                        <td>:</td>
                        <td>
                            @if($data['custom']->media=='kayu')
                            Kayu Jati
                            @elseif($data['custom']->media=='canvas')
                            Canvas
                            @endif
                        </td>
                    </tr>
                </table>
                <hr>
                <a id="update_bayar" href="{{url('blog/custom/cetak',$data['custom']->id)}}" target="_blank" class="btn btn-success">CETAK NOTA</a>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        KOMENTAR PRODUK
                    </div>
                    <div class="col-md-12">
                        <textarea id="comment"></textarea>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success btn-sm" onclick="simpanc()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 p-2 card">
            <div class="card p-2" style="height: 300px; overflow-y: auto" id="ichat">
            </div>
            <div class="card p-2">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" aria-label="Pesan" name="pesan">
                        <input type="hidden" class="form-control" name="chat" value="{{$data['custom']->id}}">
                        <input type="hidden" class="form-control" name="penerima" value="{{$data['custom']->id_pemasar}}">
                        <div class="input-group-prepend">
                            <button type="button" onclick="kirim()" class="btn btn-success">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripting')
<script type="text/javascript">

    // chat auto paling bawah
    let chatList = document.getElementById("ichat");
    chatList.scrollTop = chatList.scrollHeight

    const Toast = Swal.mixin({
    	toast: true,
    	position: 'top-end',
    	showConfirmButton: false,
    	timer: 3000,
    	timerProgressBar: true,
    	didOpen: (toast) => {
    		toast.addEventListener('mouseenter', Swal.stopTimer)
    		toast.addEventListener('mouseleave', Swal.resumeTimer)
    	}
    })

    load_chat();
    load_harga();
    load_bayar();
    load_ratting();
    load_comment();
    load_gb1('gambar1');
    load_d1('gambar1');
    load_gb2('gambar2');
    load_d2('gambar2');
    load_gb3('gambar3');
     load_d3('gambar3');
    load_gb4('gambar4');
    load_d4('gambar4');

    function kirim(){
    	$.ajax({
    		url:'{{route('blog.custom.p_chat')}}',
    		type:'post',
    		data:{
    			'_token':'{{csrf_token()}}',
    			'chat':$('[name=chat]').val(),
    			'penerima':$('[name=penerima]').val(),
    			'pesan':$('[name=pesan]').val(),
    		},
    		success:function(data){
    			$('[name=pesan]').val('');
    			chatList.scrollTop = chatList.scrollHeight
    			load_chat();
                // console.log(data);
            },
            error:function(data){
            	Toast.fire({
            		icon: 'error',
            		title: 'Pesan tidak boleh Kosong !!',
            	});
                // console.log('gak');
            }
        });
    }

    function simpan(){
        $.ajax({
            url:'{{route('blog.custom.ratting')}}',
            type:'post',
            data:{
                '_token':'{{csrf_token()}}',
                'ratting':$('#ratting').val(),
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                // $('[name=pesan]').val('');
                // chatList.scrollTop = chatList.scrollHeight
                load_ratting();
                console.log(data);
            },
            error:function(data){
                Toast.fire({
                    icon: 'error',
                    title: 'Pesan tidak boleh Kosong !!',
                });
                // console.log('gak');
            }
        });
    }
    function simpanc(){
        $.ajax({
            url:'{{route('blog.custom.comment')}}',
            type:'post',
            data:{
                '_token':'{{csrf_token()}}',
                'comment':$('#comment').val(),
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                // $('[name=pesan]').val('');
                // chatList.scrollTop = chatList.scrollHeight
                load_comment();
                console.log(data);
            },
            error:function(data){
                Toast.fire({
                    icon: 'error',
                    title: 'Pesan tidak boleh Kosong !!',
                });
                // console.log('gak');
            }
        });
    }
    function load_ratting(){
        $.ajax({
            url:'{{route('blog.custom.load_ratting')}}',
            type:'get',
            data:{
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                $('#hsratting').html(data)
            }
        });
    }

    function load_comment(){
        $.ajax({
            url:'{{route('blog.custom.load_comment')}}',
            type:'get',
            data:{
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                $('#comment').html(data)
            }
        });
    }

    function load_chat() {
    	$.ajax({
    		url:'{{route('blog.custom.get_chat')}}',
    		type:'get',
    		data:{
    			'id':$('[name=chat]').val(),
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#ichat').html(data);
    			},0);
    		}
    	});
    	chatList.scrollTop = chatList.scrollHeight
    }

    function load_harga(){
    	$.ajax({
    		url:'{{route('blog.custom.get_harga')}}',
    		type:'get',
    		data:{
    			'id':"{{$data['custom']->id}}",
    		},
    		success:function(data){
    			setTimeout(function(){
    				$('#harg').html(data)
    			},0)
    		}
    	});
    }

    function load_bayar(){
        $.ajax({
            url:'{{route('blog.custom.get_bayar')}}',
            type:'get',
            data:{
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                // setTimeout(function(){
                    // console.log(data);
                    if (data=='dibayar') {
                        $('#update_bayar').show();
                    }
                    else{
                        $('#update_bayar').hide();
                    }
                // },0)
            }
        });
    }

    function load_gb1($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_gb')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#gb1').html(data);
    			},0)
    		}
    	});
    }
    function load_d1($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_d')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#d1').html(data);
    			},0)
    		}
    	});
    }

    function load_gb2($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_gb')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#gb2').html(data);
    			},0)
    		}
    	});
    }
    function load_d2($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_d')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#d2').html(data);
    			},0)
    		}
    	});
    }

    function load_gb3($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_gb')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#gb3').html(data);
    			},0)
    		}
    	});
    }
    function load_d3($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_d')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#d3').html(data);
    			},0)
    		}
    	});
    }

    function load_gb4($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_gb')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#gb4').html(data);
    			},0)
    		}
    	});
    }
    function load_d4($a){
    	$.ajax({
    		url:'{{route('blog.custom.get_d')}}',
    		type:'get',
    		data:{
    			'id' : "{{$data['custom']->id}}",
    			'gambar':$a,
    		},
    		success:function(data){
    			setTimeout(function(){
    				// console.log(data);
    				$('#d4').html(data);
    			},0)
    		}
    	});
    }

    setInterval(function(){
    	chatList.scrollTop = chatList.scrollHeight
    	load_chat();
    	load_harga();
        load_bayar();
        load_gb1('gambar1');
        load_d1('gambar1');
        load_gb2('gambar2');
        load_d2('gambar2');
        load_gb3('gambar3');
        load_d3('gambar3');
        load_gb4('gambar4');
        load_d4('gambar4');
    }, 5000);
</script>
@endpush