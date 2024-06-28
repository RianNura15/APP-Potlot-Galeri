<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit"method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_edit">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input name="nama_edit" type="text" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input name="email_edit" type="email" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputNoHp">No Hp</label>
                        <input name="nohp_edit" type="text" class="form-control" id="exampleInputNoHp"
                            aria-describedby="emailHelp">
                    </div>

                    <label for="exampleInputKtp">KTP</label>
                    <div class="row">
                        <div class="col-auto">
                            <img id="ktp" src="" width="100px" height="100px">
                        </div>
                        <div class="col">
                            <input name="ktp_edit" type="file" class="form-control" id="exampleInputKtp"
                                aria-describedby="emailHelp">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="edit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>