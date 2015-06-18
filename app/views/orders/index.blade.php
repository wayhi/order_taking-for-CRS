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

    	<div class='col-md-12 col-lg-12'>
			<h2>我的订单</h2><br>
			<table class="table n_table" >
	
		        <thead>
		            <tr class='warning'>
		                
		                
		                <th>活动名称<br>Activity</th>
		                <th>商品总数 <br> Total Qty</th>
		                <th>总金额 <br> Total Amount</th>
		                <th>支付方式<br>Payment Method</th>
                        <th>商品SKU<br>SKU Code</th>
                        <th>商品名<br>Item Name</th>  
                        <th>数量<br>Qty</th>   
		                
		            </tr>
		        </thead>
				<tbody>
					@foreach ($orders_2 as $order_2)
						@for($i=0;$i<count($order_2->order_items);$i++)
                            <tr>
                                @if($i==0)
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order_2->order_items)}}">
                                        {{$order_2->activity_id}}
                                    </td>
                                   
                                    
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order_2->order_items)}}">{{$order->qty_total}}</td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order_2->order_items)}}">{{$order->amount_actual}}</td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order_2->order_items)}}">
                                    @if($order_2->pmt_method==1)工资抵扣 
                                    @elseif($order_2->pmt_method==0)Credit Card 
                                    @elseif($order_2->pmt_method==2)Free
                                    @endif
                                    </td>
                                    
                                @endif
                                
                                <td style="vertical-align:middle; text-align:center;">{{$order_2->order_items[$i]->item->SKU_code}}</td>
                                <td style="vertical-align:middle; text-align:center;">{{$order_2->order_items[$i]->item->item_name}}</td>
                                <td style="vertical-align:middle; text-align:center;">{{$order_2->order_items[$i]->qty}}</td>
                                
                            </tr>
                        @endfor
					
					@endforeach
				</tbody>
			</table>		
		</div>
		


    </div>

    </div>
    
  </div>

</div>


@stop