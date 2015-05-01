@extends('default_order')
@section('main')

{{ Notification::showAll() }}

 {{Former::horizontal_open()->id('OrderSearch')->Method('POST')->route('orders.manage_post')}}
<div class='row'>
        
        <div class='col-md-2 col-lg-2'>
           
            {{Former::select('activity_id','所属活动: ')->fromQuery(Activity::all(),'name','id')->class('form-control')}}
        </div>    
        <div class='col-md-3 col-lg-3'>
            {{Former::select('item_id','产品: ')->fromQuery(Item::all(),'item_name','id')->class('form-control')}}
        </div>    
        <div class='col-md-2 col-lg-2'>
            {{Former::select('user_id','用户: ')->fromQuery(User::all(),'last_name','id')->class('form-control')}}
        </div>  
        <div class='col-md-2 col-lg-2'>
            {{Former::select('pmt_method','支付方式: ')->options([-1=>'所有-All',0=>'Credit Card',1=>'Salary',2=>'Free'])->class('form-control')}}
        </div>  
         <div class='col-md-3 col-lg-3' > 
                <div class="control-group">   
                 <label class="control-label"> <br></label>
                 <div class="controls">
                     
                     {{Former::submit('查询')->class('btn btn-primary btn-sm')->name('submit')}}
                     
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        导出 <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href = "{{URL::route('orders.export',['type'=>'orderform','activity_id'=>$activity_id])}}" >Order Form</a></li>
                        
                        <li><a href = "{{URL::route('orders.export',['type'=>'summary','activity_id'=>$activity_id])}}">Summary</a></li>
                        
                        
                      </ul>
                    </div>
                     <a class='btn btn-default btn-sm' href="{{URL::route('items.index')}}" >返回</a>
                 
                 </div>
                 </div>
        </div>  
        
</div>
  
<div class='col-md-12 col-lg-12'>
    
    <div class='row'>
       
            <h2 align='center'>订单汇总</h2>
        
        <table class="table n_table table-bordered" >
            
                <thead>
                    <tr class='warning'>
                        
                        <th>用户姓名<br>Name</th>
                        <th>订单号<br>Order #</th>
                        <th>商品总数 <br> Total Qty</th>
                        <th>订单时间<br>Order Time</th>
                        <th>支付方式<br>Payment Method</th>
                        <th>总金额 <br> Total Amount</th>
                        <th>商品SKU<br>SKU Code</th>
                        <th>商品名<br>Item Name</th>  
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
                                        <a href='{{URL::Route('orders.admin',Crypt::encrypt($order->id))}}'>{{$order->order_number}}</a>
                                    </td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->qty_total}}</td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->created_at}}</td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">
                                    @if($order->pmt_method==1)工资抵扣 
                                    @elseif($order->pmt_method==0)Credit Card 
                                    @elseif($order->pmt_method==2)Free
                                    @endif
                                    </td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->amount_actual}}</td>
                                @endif
                                
                                <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->item->SKU_code}}</td>
                                <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->item->item_name}}</td>
                                <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->qty}}</td>
                                
                            </tr>
                        @endfor
                    
                    @endforeach
                   
                </tbody>
                <tfoot><tr> <td colspan=6 align='right'><b>Total Amount: {{$totalamount}}</b></td><td colspan=3 align='right'><b>Total Quantity: {{$qty_total}}</b></td></tr></tfoot>
        </table>  
    <div class='pagination inline'>{{$orders->links();}}</div>        
</div>
<div class='col-md-offset-4 col-md-6 col-lg-6'>
        
        
</div>
{{Former::close()}} 
@stop