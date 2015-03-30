@extends('default_order')
@section('main')

{{ Notification::showAll() }}

 {{Former::horizontal_open()->id('OrderSearch')->Method('POST')->route('orders.manage_post')}}
<div class='row'>
        
        <div class='col-md-4 col-lg-4'>
           
            {{Former::select('activity_id','所属活动: ')->fromQuery(Activity::all(),'name','id')->class('form-control')}}
        </div>    
        <div class='col-md-4 col-lg-4'>
            {{Former::select('item_id','产品: ')->fromQuery(Item::all(),'item_name','id')->class('form-control')}}
        </div>    
        <div class='col-md-2 col-lg-2'>
            {{Former::select('user_id','用户: ')->fromQuery(User::all(),'last_name','id')->class('form-control')}}
        </div>  
         <div class='col-md-2 col-lg-2' > 
                <div class="control-group">   
                 <label class="control-label"> <br></label>
                 <div class="controls">
                     
                     {{Former::submit('查询')->class('btn btn-primary btn-sm')->name('submit')}}
                     <!--{{Former::submit('导出')->class('btn btn-warning btn-sm')->name('export')}} -->
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
                        
                        <th>用户姓名<br>Customer Name</th>
                        <th>订单号<br>Order #</th>
                        <th>商品总数 <br> Total Quantity</th>
                        <th>总金额 <br> Total Amount</th>
                        <th>订单时间<br>Created at</th>
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
                                        <a href='{{URL::Route('orders.show',Crypt::encrypt($order->id))}}'>{{$order->order_number}}</a>
                                    </td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->qty_total}}</td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->amount_actual}}</td>
                                    <td style="vertical-align:middle; text-align:center;" rowspan="{{count($order->order_items)}}">{{$order->created_at}}</td>
                                @endif
                                
                                <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->item->SKU_code}}</td>
                                <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->item->item_name}}</td>
                                <td style="vertical-align:middle; text-align:center;">{{$order->order_items[$i]->qty}}</td>
                                
                            </tr>
                        @endfor
                    
                    @endforeach
                </tbody>
        </table>  
    <div class='pagination inline'>{{$orders->links();}}</div>        
</div>
<div class='col-md-offset-4 col-md-6 col-lg-6'>
        
        
</div>
{{Former::close()}} 
@stop