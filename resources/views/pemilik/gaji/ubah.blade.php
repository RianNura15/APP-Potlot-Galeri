<div class="modal fade" id="ubah{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ubah Gaji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('pemilik/home/detail/ubah/')}}/{{$id}}/ubah/{{$value->tgl_gaji}}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group" id="gajian">
            <input type="number" class="form-control" aria-label="gaji" id="gajian" name="gajian" value="{{$value->gaji}}">
            <div class="input-group-prepend">
              <button type="submit" class="btn btn-success">Kirim</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>