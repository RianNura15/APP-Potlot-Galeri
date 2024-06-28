@extends('layouts.admin.app')

@push('styleshet')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 card">
            <div class="card-header">
                Lukisan
            </div>
            <div class="card-body">
                @if($data['custom']->gambar1==NULL)
                <form method="post" id="luk" enctype="multipart/form-data" action="{{url('marketing/transaksi/chat',$data['custom']->id)}}">
                    @csrf
                    <input type="hidden" name="gambar" value="file1">
                    <input type="file" name="file" class="form-control col-md-12">
                    <button type="submit" class="btn btn-primary col-md-12 mt-2">Upload</button>
                </form>
                @else
                <img class="img-fluid img-thumbnail" src="{{asset('public\custom\gmb1')}}\{{$data['custom']->gambar1}}" alt="">
                @endif
            </div>
        </div>
        <div class="col-md-3 card">
            <div class="card-header">
                Perbaikan 1
            </div>
            <div class="card-body">
                @if($data['custom']->gambar2==NULL)
                <form method="post" id="luk" enctype="multipart/form-data" action="{{url('marketing/transaksi/chat',$data['custom']->id)}}">
                    @csrf
                    <input type="hidden" name="gambar" value="file2">
                    <input type="file" name="file" class="form-control col-md-12">
                    <button type="submit" class="btn btn-primary col-md-12 mt-2">Upload</button>
                </form>
                @else
                <img class="img-fluid img-thumbnail" src="{{asset('public\custom\gmb2')}}\{{$data['custom']->gambar2}}" alt="">
                @endif
            </div>
        </div>
        <div class="col-md-3 card">
            <div class="card-header">
            Perbaikan 2
            </div>
            <div class="card-body">
                @if($data['custom']->gambar3==NULL)
                <form method="post" id="luk" enctype="multipart/form-data" action="{{url('marketing/transaksi/chat',$data['custom']->id)}}">
                    @csrf
                    <input type="hidden" name="gambar" value="file3">
                    <input type="file" name="file" class="form-control col-md-12">
                    <button type="submit" class="btn btn-primary col-md-12 mt-2">Upload</button>
                </form>
                @else
                <img class="img-fluid img-thumbnail" src="{{asset('public\custom\gmb3')}}\{{$data['custom']->gambar3}}" alt="">
                @endif
            </div>
        </div>
        <div class="col-md-3 card">
            <div class="card-header">
            Perbaikan 3
            </div>
            <div class="card-body">
                @if($data['custom']->gambar4==NULL)
                <form method="post" id="luk" enctype="multipart/form-data" action="{{url('marketing/transaksi/chat',$data['custom']->id)}}">
                    @csrf
                    <input type="hidden" name="gambar" value="file4">
                    <input type="file" name="file" class="form-control col-md-12">
                    <button type="submit" class="btn btn-primary col-md-12 mt-2">Upload</button>
                </form>
                @else
                <img class="img-fluid img-thumbnail" src="{{asset('public\custom\gmb4')}}\{{$data['custom']->gambar4}}" alt="">
                @endif
            </div>
            <div class="card-footer">
                @if($data['custom']->gambar4!==NULL)
                <form method="post" id="luk" enctype="multipart/form-data" action="{{url('marketing/transaksi/chat',$data['custom']->id)}}">
                    @csrf
                    <input type="hidden" name="gambar" value="file4">
                    <input type="file" name="file" class="form-control col-md-12">
                    <button type="submit" class="btn btn-primary col-md-12 mt-2">Upload</button>
                </form>
                @endif
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
                    <tr>
                        <td>Komentar</td><td>:</td><td><span id="comment"></span></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <table class="table-sm">
                    <tr>
                        <td>Pemesan</td><td>:</td><td><span class="justify-content-center" id="marketing">{{App\User::nama_pemesan($data['custom']->id_cust)}}</span></td>
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
                <div class="input-group" id="update_bayar">
                    <input type="number" class="form-control" aria-label="Harga" id="harga" name="harga" value="{{$data['custom']->harga}}">
                    <div class="input-group-prepend">
                        <button type="button" onclick="update()" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 p-2 card">
            <div class="card p-2" style="height: 300px; overflow-y: auto" id="ichat">
            </div>
            <div class="card p-2">
                <div class="input-group">
                    <input type="text" class="form-control" aria-label="Pesan" name="pesan">
                    <input type="hidden" class="form-control" name="chat" value="{{$data['custom']->id}}">
                    <input type="hidden" class="form-control" name="penerima" value="{{$data['custom']->id_cust}}">
                    <div class="input-group-prepend">
                        <button type="button" onclick="kirim()" class="btn btn-success">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripting')
<script type="text/javascript">

    function reload(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

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

    load_harga()
    load_bayar()
    load_ratting();
    load_comment();

    function kirim(){
        $.ajax({
            url:'{{route('marketing.transaksi.p_chat')}}',
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

    function load_ratting(){
        $.ajax({
            url:'{{route('marketing.transaksi.load_ratting')}}',
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
            url:'{{route('marketing.transaksi.load_comment')}}',
            type:'get',
            data:{
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                $('#comment').html(data)
            }
        });
    }

    function gmb($a){
        console.log($a);
    }

    function update(){
        // console.log('hrg');
        $.ajax({
            url:'{{route('marketing.transaksi.p_harga')}}',
            type:'get',
            data:{
                'id':$('[name=chat]').val(),
                'harga':$('#harga').val(),
            },
            success:function(data){
                $('#harg').html(data)
                $('[name=harga]').val(data);
                console.log(data);
            },
            error:function(data){
                // console.log('eror');
                Toast.fire({
                  icon: 'error',
                  title: 'Harus diatas 0 !!',
              });
                // console.log('gak');
            }
        });
    }

    function load_chat() {
        $.ajax({
            url:'{{route('marketing.transaksi.get_chat')}}',
            type:'get',
            data:{
                'id':$('[name=chat]').val(),
            },
            success:function(data){
                setTimeout(function(){
                    $('#ichat').html(data)
                },0);
            }
        });
        chatList.scrollTop = chatList.scrollHeight
    }

    function load_harga(){
        $.ajax({
            url:'{{route('marketing.transaksi.get_harga')}}',
            type:'get',
            data:{
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                // setTimeout(function(){
                    $('#harg').html(data);
                // },0)
            }
        });
    }

    function load_bayar(){
        $.ajax({
            url:'{{route('marketing.transaksi.get_bayar')}}',
            type:'get',
            data:{
                'id':"{{$data['custom']->id}}",
            },
            success:function(data){
                // setTimeout(function(){
                    // console.log(data);
                    if (data=='dibayar') {
                        $('#update_bayar').hide();
                    }
                    else{
                        $('#update_bayar').show();
                    }
                // },0)
            }
        });
    }

    setInterval(function(){
        chatList.scrollTop = chatList.scrollHeight
        load_chat();
        load_harga();
        load_bayar();
        load_ratting();
        load_comment();
    }, 5000);
</script>
@endpush