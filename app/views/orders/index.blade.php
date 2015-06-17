@extends('default')
@section('main')

{{ Notification::showAll() }}
<script>
  $(function () {
    $('#myTab a:first').tab('show')
  })
</script>
<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#by_order" aria-controls="by_order" role="tab" data-toggle="tab">By Order</a></li>
    <li role="presentation"><a href="#by_activity" aria-controls="profile" role="tab" data-toggle="tab">By Activity</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="by_order">
    	<div class='col-md-12 col-lg-12'>
			<h2>我的订单</h2><br>
			<table class="table n_table" >
	
		        <thead>
		            <tr class='warning'>
		                
		                <th>订单号<br>Order #</th>
		                <th>活动名称<br>Activity</th>
		                <th>商品总数 <br> Quantity</th>
		                <th>总金额 <br> Total Amount</th>
		                <th>支付方式<br>Payment Method</th>
		                <th>订单时间<br>Created at</th>   
		                
		            </tr>
		        </thead>
				<tbody>
					@foreach ($orders as $order)
					@if($order->status==1)<tr>
					@elseif($order->status==2)<tr class='success'>
					@endif
					<td><a href='{{URL::Route('orders.show',Crypt::encrypt($order->id))}}'>{{$order->order_number}}</a></td>
					<td>{{$order->activity->name}}</td>
					<td>{{$order->qty_total}}</td>
					<td>{{$order->amount_actual}}</td>
					<td>
					@if($order->pmt_method==1)工资抵扣
					@elseif($order->pmt_method==0)Credit Card
					@endif
					</td>
					<td>{{$order->created_at}}</td>
					</tr>
					
					@endforeach
				</tbody>
			</table>		
		</div>
		<div class='pagination inline'>{{$orders->links();}}</div>


    </div>
    <div role="tabpanel" class="tab-pane fade" id="by_activity">


    </div>
    
  </div>

</div>


@stop