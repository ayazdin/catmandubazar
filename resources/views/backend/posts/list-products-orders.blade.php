<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">

		@if(!empty($orders))
		<div class="row">
	    	<div class="col-xs-12">
		      	<div class="box">
		      		<div class="box-header">
		      			<h3 class="box-title">Product Orders</h3>
		      		</div>
					<div class="box-body table-responsive no-padding">
						@if(!empty($succ))
						<div class="alert alert-success" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Success!</strong> {{ $succ }}
						</div>
						@endif
						@if(!empty(session('succ')))
						<div class="alert alert-success" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Success!</strong> {{ session('succ') }}
						</div>
						@endif
						<table class="table table-hover">
						    <tr>
							    <th>Order ID</th>
							    <th>Date</th>
							    <th>Items</th>
									<th>Total</th>
									<th>Status</th>
							    <th></th>
						    </tr>

							@foreach ($orders as $order)
							<tr>
								<td><a href="<?php echo url('/admin/product/view-order/')."/".$order->orderid;?>">{{ $order->orderid }}</a></td>
              	<td>{{Carbon\Carbon::parse($order->updated_at)->format('d M, Y')}}</td>
              	<td>{{ $order->items }}</td>
              	<td>Rs. {{ number_format($order->total * $exRate, 2, '.', ',')}}</td>
								<td>
									@if($order->cart_status=='sales')
                    Ordered
                  @else
                    No Order
                  @endif
								</td>
              	<td>

								</td>
              </tr>
							@endforeach
						</table>
			        </div>
				</div>
			</div>
		</div>
		<div class="row">
	    	<div class="col-xs-12">
		      	<div class="box box-default box-solid">
		      		<div class="box-body">
		              {{ $orders->links('admin.partials.paginators') }}
		            </div>
			    </div>
			</div>
		</div>
		@endif
	</section>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
						Confirm Delete
				</div>
				<div class="modal-body">
						Are you sure to delete this product???
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a class="btn btn-danger btn-ok">Delete</a>
				</div>
		</div>
	</div>
</div>
@push('adminjs')
<script>
$('#confirm-delete').on('show.bs.modal', function(e) {
	$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
</script>
@endpush
