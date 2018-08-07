<div class="content-wrapper">
<section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Yalamart Product Order View
            <small class="pull-right">Date: {{Carbon\Carbon::parse($orders[0]->updated_at)->format('d M, Y')}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>{{$customer['firstname']}} {{$customer['lastname']}}</strong><br>
            <!--795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>-->
            @if(isset($customer['phone']))
            Phone: {{$customer['phone']}}<br>
            @endif
            Email: {{$customer['email']}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Order ID:</b> {{$orders[0]->orderid}}<br>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
	            <th>Item</th>
    			    <th>Name</th>
    			    <th>Url</th>
    			    <th>Qty</th>
    			    <th>Subtotal</th>
              <th>Shipping</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
        	@php
        	$total=0;
          $shipDate="";
          $shipStatus="";
        	@endphp
            @if($orders->isNotEmpty())
            @foreach($orders as $order)
            <tr>
              <td><a href="/prepare-quote/{{$order->id}}">#{{$order->id}}</a></td>
              <td>{{$order->title}}</td>
              <td><a href="item/{{$order->clean_url}}" target="_blank">View Product</a></td>
              <td>{{$order->quantity}}</td>
              <?php $finalcost = number_format($order->price * $order->quantity * $exRate, 2, '.', ',');?>
              <td>Rs. {{number_format($order->price * $order->quantity * $exRate, 2, '.', ',')}}</td>
              <td>{{($order->ship_status!="")?$order->ship_status->status:'In Progress'}}</td>
              <td>
                  <a href="#">Status</a>
              </td>
            </tr>
            @php
            $total += $finalcost;
            @endphp
            @endforeach
            @endif
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">

        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Final Cost of Order</p>

          <div class="table-responsive">
            <table class="table">
              <tbody>
              <tr>
                <th>Total:</th>
                <td>Rs. {{$total}}</td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

</div>
