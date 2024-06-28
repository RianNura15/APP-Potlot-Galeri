<html>
	  <head>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
	    <script type="text/javascript"
	      src="https://app.midtrans.com/snap/snap.js"
	      data-client-key="SET_YOUR_CLIENT_KEY_HERE"></script>
	    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
	  </head>

	  <body>
      {{-- {{$token}}
	    <button id="pay-button">Pay!</button> --}}
			<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
			<script type="text/javascript">
			$.ajaxSetup({
		    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
			});
			var toastMixin = Swal.mixin({
		    toast: true,
		    icon: 'success',
		    title: 'General Title',
		    animation: false,
		    position: 'top-right',
		    showConfirmButton: false,
		    timer: 3000,
		    timerProgressBar: true,
		    didOpen: (toast) => {
		      toast.addEventListener('mouseenter', Swal.stopTimer)
		      toast.addEventListener('mouseleave', Swal.resumeTimer)
		    }
		  });
				 window.snap.pay('{{$data['token']}}', {
					 onSuccess: function(result){
						  save(result)
							toastMixin.fire({
								animation: true,
								title: 'Berhasil melakukan pembayaran'
							});
					 },
					 onPending: function(result){
						 toastMixin.fire({
							 animation: true,
							 icon:'warning',
							 title: 'Menunggu Pembayaran'
						 });
						 setTimeout(function() {
							 window.location.href = "{{route('blog.keranjang.index')}}";
						 }, 3000);
					 },
					 onError: function(result){
						 toastMixin.fire({
							animation: true,
							icon:'error',
							title: 'Gagal melakukan pembayaran'
						});
						setTimeout(function() {
							window.location.href = "{{route('blog.keranjang.index')}}";
						}, 3000);
					 },
					 onClose: function(){
						 window.location.href = "{{route('blog.keranjang.index')}}";
					 }
				 })
				 function save(result){
					 var data = new FormData();
					 data.append('_token','{{csrf_token()}}');
					 data.append('data',JSON.stringify(result));
					 data.append('id_booking','{{$data['id_cart']}}');
					 $.ajax({
					   url:'{{route('blog.order.status')}}',
					   type:'post',
					   processData:false,
					   contentType:false,
					   data:data,
					   success:function(data){
					      setTimeout(function() {
					        window.location.href = "{{route('blog.keranjang.index')}}";
					      }, 3000);
					   },error:function(data){
					     toastMixin.fire({
					       animation: true,
					       icon:eror,
					       title: 'Gagal melakukan pembayaran'
					      });
					   }
					  });
			 }
		 </script>
	  </body>
	</html>
