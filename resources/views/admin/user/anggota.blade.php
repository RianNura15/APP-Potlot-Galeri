@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    @include('admin.user.modal_detail')
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Form Anggota</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="form_anggota" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama</label>
                                            <input name="nama" type="text" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input name="email" type="email" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input name="password" type="password" class="form-control"
                                                id="exampleInputPassword1">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputNoHp">No Hp</label>
                                            <input name="noHp" type="text" class="form-control" id="exampleInputNoHp">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputKtp">KTP</label>
                                            <input name="file" type="file" class="form-control" id="exampleInputKtp">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="h5">Daftar Anggota</p>
                        <button type="button" data-toggle="modal" data-target="#exampleModalCenter"
                            class="btn btn-sm btn-info" name="button"> Tambah</button>
                        <hr>
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Kode Referal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripting')
    <script type="text/javascript">
        $('.table').DataTable({
            paging: true,
            lengthChange: true,
            autoWidth: true,
            processing: true,
            serverSide: true,
            orderable: true,
            searchable: true,
            searchDelay: 1000,
            ordering: false,
            scrollX: true,
            scrollCollapse: true,
            language: {
                processing: "Sedang diproses..."
            },
            ajax: {
                url: '{{ route('admin.user.get_anggota') }}',
                type: 'get',
                contentType: 'application/json',
            },
            columns: [{
                    data: "id",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "name"
                },
                {
                    data: "email"
                },
                {
                    data: "koderef_mark"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        if (data.verif == 'login') {
                            if (data.koderef_mark === null) {
                                return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                    '<button onclick="detail(' + data.id +
                                    ')" class="btn btn-sm btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Detail Anggota</button>' +
                                    '<button class="btn btn-sm btn-danger" onclick="hapus(' + data.id +
                                    ')"> Hapus</button>' +
                                    '<button class="btn btn-sm btn-primary" onclick="koderef(' + data.id +
                                    ')"> Generate Kode</button>' +
                                    '</div>';
                            } else {
                                return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                    '<button onclick="detail(' + data.id +
                                    ')" class="btn btn-sm btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Detail Anggota</button>' +
                                    '<button class="btn btn-sm btn-danger" onclick="hapus(' + data.id +
                                    ')"> Hapus</button>' +
                                    '</div>';
                            }
                        } else {
                            return '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<button onclick="detail(' + data.id +
                                ')" class="btn btn-sm btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Detail Anggota</button>' +
                                '<button class="btn btn-sm btn-warning" onclick="verif(' + data.id +
                                ')"> Verif</button>' +
                                '<button class="btn btn-sm btn-danger" onclick="hapus(' + data.id +
                                ')"> Hapus</button>' +
                                '</div>';
                        }
                    }
                },
            ]
        });

        function detail(id) {
            $.ajax({
                url: '{{ route('admin.user.detail_anggota') }}',
                type: 'get',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#modal_detail').modal('show');
                    $('[name=id_edit]').val(data.id)
                    $('[name=nama_edit]').val(data.name)
                    $('[name=email_edit]').val(data.email)
                    $('[name=nohp_edit]').val(data.no_hp)
                    $('#ktp').attr("src", "http://localhost/potlot_galeri/public/images/ktp/" + data.ktp)
                }
            })
        }

        function verif(id) {
            $.ajax({
                url: '{{ route('admin.user.verif_anggota') }}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: id
                },
                success: function(data) {
                    $('.table').DataTable().ajax.reload();
                },
                error: function(data) {}
            })
        }

        // function simpan() {
        //     data = $('form').serializeArray();
        //     $.ajax({
        //         url: '{{ route('admin.user.add_anggota') }}',
        //         type: 'post',
        //         data: data,
        //         success: function(data) {
        //             $('.table').DataTable().ajax.reload();
        //             $('#exampleModalCenter').modal('hide');
        //             console.log(data);
        //         },
        //         error: function(data) {

        //         }
        //     })
        // }

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

        $('#form_anggota').submit(function(e) {
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.user.add_anggota') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#exampleModalCenter').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil menambahkan anggota',
                        text: "akan memperbarui data tabel",
                    });
                    setTimeout(function() {
                        $('.table').DataTable().ajax.reload();
                    }, 3000);
                },
                error: function(response) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal menambahkan',
                    });
                }
            });
            e.preventDefault();
        });

        $('#edit').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this)
            $.ajax({
                url: '{{ route('admin.user.edit') }}',
                type: 'post',
                processData: false,
                contentType: false,
                data: data,
                success: function(data) {
                    $('#modal_detail').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil mengubah anggota',
                        text: "akan memperbarui data tabel",
                    });
                    setTimeout(function() {
                        $('.table').DataTable().ajax.reload();
                    }, 3000);
                }
            })
        });

        
        function hapus(id) {
            $.ajax({
                url: '{{ route('admin.user.delete_anggota') }}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: id
                },
                success: function(data) {
                    $('.table').DataTable().ajax.reload();
                },
                error: function(data) {}
            })
        }
        
        function koderef(id) {
            $.ajax({
                url: '{{ route('admin.user.generate_koderef') }}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: id
                },
                success: function (data) {
                    $('.table').DataTable().ajax.reload();
                },
                error: function (data) {}
            })
        }
    </script>
@endpush
