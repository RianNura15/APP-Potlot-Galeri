@extends('layouts.blog.app')

@section('content')
  <div class="row">
  </div>
@endsection
@push('script')
  <script type="text/javascript">
  $( document ).ready(function() {
    load();
  });
    function load(){
      $.ajax({
        url:'{{route('blog.lukisan_json')}}',
        type:'get',
        success:function(data){
          setTimeout(function() {
            $('.row').html(data)
          }, 0);
        }
      })
    }
  </script>
@endpush
