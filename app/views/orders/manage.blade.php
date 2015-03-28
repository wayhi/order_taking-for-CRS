@extends('default')
@section('main')

{{ Notification::showAll() }}

<div class='col-md-12 col-lg-12'>
<h2>订单汇总</h2><br>
<table class="table n_table table-bordered" >
    
        <thead>
            <tr class='warning'>
                
                <th>用户姓名<br>Customer Name</th>
                <th>订单号<br>Order #</th>
                <th>商品总数 <br> Total Quantity</th>
                <th>总金额 <br> Total Amount</th>
                <th>订单时间<br>Created at</th>
                <th>商品SKU<br>SKU Code</th>  
                <th>数量<br>Qty</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            
                @for($i=0;$i<count($order->order_items);$i++)
                    <tr>
                        @if($i==0)
                            <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->owner->last_name}}</td>
                            <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">
                            <a href='{{URL::Route('orders.show',Crypt::encrypt($order->id))}}'>{{$order->order_number}}</a>
                            </td>
                            <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->qty_total}}</td>
                            <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->amount_actual}}</td>
                            <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->created_at}}</td>
                        @endif
                        <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->item->SKU_code}}</td>
                        <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->qty}}</td>
                    </tr>
                @endfor
            
            @endforeach
        </tbody>
</table>        
</div>
<div class='pagination inline'>{{$orders->links();}}</div>
@stop