@extends('default')
@section('main')

{{ Notification::showAll() }}

<div class='col-md-offset-2 col-md-10 col-lg-10'>
<h2><p align='center'>我的订单</p></h2><br>
<table class="table table-condensed" >
	
        <thead>
            <tr>
                
                <th>订单号<br>Order #</th>
                <th>商品总数 <br> Quantity</th>
                <th>总金额 <br> Total Amount</th>
                <th>当前状态<br>Status</th>
                <th>订单日期<br>Date</th>   
                
            </tr>
        </thead>
		<tbody>
			@foreach ($orders as $order)
			@endforeach
		</tbody>
</table>		
</div>
@stop