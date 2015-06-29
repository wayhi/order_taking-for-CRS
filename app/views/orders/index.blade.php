@extends('default')
@section('main')

{{ Notification::showAll() }}
<script>
  $(function () {

            
            (function ($) {
                $.getUrlParam = function (name) {
                    var reg = new RegExp("(^|&?)" + name + "=([^&]*)(&|$)");
                    var r = window.location.search.match(reg);
                    //alert(r);
                    if (r != null) return unescape(r[2]); return null;
                }
            })(jQuery);
            
            
            var xx = $.getUrlParam('sort');
            //alert(xx);
            if (xx == 'item') {
            	//alert('ok');
            	 $(function () {
   					$('#myTab a:last').tab('show');
  				})

            }
            if (xx == 'order') {
            	//alert('ok');
            	 $(function () {
   					$('#myTab a:first').tab('show');
  				})

            }
            

        });

        




 
</script>
<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#by_order" aria-controls="by_order" role="tab" data-toggle="tab">By Order</a></li>
    <li role="presentation"><a href="#by_item" aria-controls="profile" role="tab" data-toggle="tab">By Item</a></li>
    
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
					@elseif($order->pmt_method==0)银行卡支付
					@elseif($order->pmt_method==2)银行转账／汇款
					@endif
					</td>
					<td>{{$order->created_at}}</td>
					</tr>
					
					@endforeach
				</tbody>
			</table>		
		</div>
		<div class='pagination inline'>{{$orders->appends(array('sort' => 'order'))->links();}}</div>


    </div>
    <div role="tabpanel" class="tab-pane fade" id="by_item">

    	<div class='col-md-12 col-lg-12'>
			<h2>已购商品</h2><br>
			<table class="table n_table" >
	
		        <thead>
		            <tr class='warning'>
		                
		                
		                <th>活动名称<br>Activity</th>
                        <th>商品SKU<br>SKU Code</th>
                        <th>商品名<br>Item Name</th>  
                        <th>数量<br>Qty</th> 
                        <th>金额<br>Amount</th> 
		                
		            </tr>
		        </thead>
				<tbody>
					@foreach ($orders_2 as $order_2)
						
                            <tr>
                               <td>{{$order_2->name}}</td>
                               <td>{{$order_2->sku_code}}</td>
                               <td>{{$order_2->item_name}}</td>
                               <td>{{$order_2->item_qty}}</td>
                               <td>{{$order_2->item_amount}}</td>
                            </tr>
                        
					
					@endforeach
				</tbody>
			</table>		
		</div>
		<div class='pagination inline'>{{$orders_2->appends(array('sort' => 'item'))->links();}}</div>


    </div>

    </div>
    
  </div>

</div>


@stop