@extends('default')
@section('main')

{{ Notification::showAll() }}

<div class='col-md-offset-2 col-md-8 col-lg-8'>
<h2><p align='center'>订单内容</p></h2><br>
<table class=" table n_table" >
	
        <thead>
            <tr>
                
                <th colspan=2 style="vertical-align:middle; text-align:center;">商品 <br> Product
                
                </th>
                <th style="vertical-align:middle; text-align:center;">单价 <br> Price</th>
                <th style="vertical-align:middle; text-align:center;">数量 <br> Quantity</th>
                
                
            </tr>
        </thead>
        <tbody>
            
            @foreach($order->order_items as $order_item)
            	<tr>
                    
                    <td><image src="{{$order_item->item->image->url('micro')}}">
                    
                    </td>
                    <td style="vertical-align:middle; text-align:left;">{{$order_item->item->item_name}}</td>
                    <td style="vertical-align:middle; text-align:center;">{{$order_item->item->price_actual}}
                    </td>
                    <td style="vertical-align:middle; text-align:center;">
                   {{$order_item->qty}}
                    </td>  
                </tr>
               @endforeach
           
           <tr>
        
        <td  colspan=4 align='right'><div class='pull-right'>Total Amount 总价：¥{{$order->amount_actual}}
        </div></td>
        
        </tr>
        
        </tbody>
        
        
    </table>
    <div class='col-md-offset-4 col-md-6 col-lg-6'>
    	
    	<a class='btn btn-default btn-sm' href='/orders' >关闭</a>
    </div>
    </div>

    
    @stop
     

              
              
			