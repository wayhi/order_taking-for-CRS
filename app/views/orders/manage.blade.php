@extends('default')
@section('main')

{{ Notification::showAll() }}

<div class='col-md-12 col-lg-12'>
<h2>订单汇总</h2><br>
<table class="table n_table" >
    
        <thead>
            <tr class='warning'>
                
                <th>用户姓名<br>Customer Name</th>
                <th>订单号<br>Order #</th>
                <th>活动名称<br>Activity</th>
                <th>商品总数 <br> Quantity</th>
                <th>总金额 <br> Total Amount</th>
                <th>当前状态<br>Status</th>
                <th>订单时间<br>Created at</th>   
                
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            @if($order->status==1)<tr>
            @elseif($order->status==2)<tr class='success'>
            @endif
            <td rowspan="{{count($order->order_items)}}">$order->owner->last_name</td>
            <td><a href='{{URL::Route('orders.show',Crypt::encrypt($order->id))}}'>{{$order->order_number}}</a></td>
            <td>{{$order->activity->name}}</td>
            <td>{{$order->qty_total}}</td>
            <td>{{$order->amount_actual}}</td>
            <td>
            @if($order->status==1)已提交
            
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