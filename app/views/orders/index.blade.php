@extends('default')
@section('main')

{{ Notification::showAll() }}

<div class='col-md-12 col-lg-12'>
<h2>我的订单</h2><br>
<table class="table n_table" >
	
        <thead>
            <tr>
                
                <th>订单号<br>Order #</th>
                <th>商品总数 <br> Quantity</th>
                <th>总金额 <br> Total Amount</th>
                <th>当前状态<br>Status</th>
                <th>订单时间<br>Created at</th>   
                
            </tr>
        </thead>
		<tbody>
			@foreach ($orders as $order)
			@if($order->status==1)<tr class='warning'>
			@elseif($order->status==2)<tr class='success'>
			@endif
			<td><a href='{{URL::Route('orders.show',Crypt::encrypt($order->id))}}'>{{$order->order_number}}</a></td>
			<td>{{$order->qty_total}}</td>
			<td>{{$order->amount_actual}}</td>
			<td>
			@if($order->status==1)待处理
			@elseif($order->status==2)已完成
			@endif
			</td>
			<td>{{$order->created_at}}</td>
			</tr>
			
			@endforeach
		</tbody>
</table>		
</div>
<div class='pagination inline'>{{$orders->links();}}</div>
@stop