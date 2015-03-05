@extends('default')
@section('main')
<script language='javascript'>
	function addqty(qty,qty_,price){
		//alert(document.getElementById(e).value);
		document.getElementById(qty).value =parseInt(document.getElementById(qty).value)+1;
		document.getElementById(qty_).value = document.getElementById(qty).value;
		document.getElementById('totalamount').value = 
		parseFloat(document.getElementById('totalamount').value) + parseFloat(price);
		
	}
	function reduceqty(q,q_,price){
	
		
		var qty = parseInt(document.getElementById(q).value)-1;
		if(qty<0){
			document.getElementById(q).value =0;
			document.getElementById(q_).value=0;
		}else{
			document.getElementById(q).value = qty;
			document.getElementById(q_).value = qty;
			document.getElementById('totalamount').value = 
		parseFloat(document.getElementById('totalamount').value) - parseFloat(price);
		}
		
	}
	
	function calculate_amount(){
		
	
	}
	
</script>
{{ Notification::showAll() }}
{{Former::secure_open()->id('shopping_cart')->Method('POST')->route('orders.store')}}
<div class='col-md-offset-2 col-md-6 col-lg-6'>
<h2><p align='center'>我的购物车</p></h2><br>
<table style="background-color:#fff;font-size:12px;" class="table table-condensed" >
	
        <thead>
            <tr>
                
                <th colspan=2 style="vertical-align:middle; text-align:center;">商品 <br> Product
                <input type='hidden' name='itemcount' value='{{$itemcount}}'>
                </th>
                <th style="vertical-align:middle; text-align:center;">单价 <br> Price</th>
                <th style="vertical-align:middle; text-align:center;">数量 <br> Quantity</th>
                
                
            </tr>
        </thead>
        <tbody>
            
            @for($i=0;$i<$itemcount;$i++)
            	<tr>
                    
                    <td><image src="{{$items[$i]->image->url('micro')}}">
                    <input type='hidden' name='item_id{{$i}}' value='{{$items[$i]->id}}'>
                    </td>
                    <td style="vertical-align:middle; text-align:left;">{{$items[$i]->item_name}}</td>
                    <td style="vertical-align:middle; text-align:center;">{{$items[$i]->price_actual}}
                    <input type='hidden' name='item_price{{$i}}' value='{{$items[$i]->price_actual}}'>
                    <input type='hidden' name='item_price_o{{$i}}' value='{{$items[$i]->price_original}}'>
                    
                    </td>
                    <td style="vertical-align:middle; text-align:center;">
                    <button class='btn btn-default btn-xs' type='button' onclick="reduceqty('qty{{$items[$i]->id}}','qty_{{$items[$i]->id}}',{{$items[$i]->price_actual}})">-</button>
                    <input type='button' class='btn btn-default btn-xs' name='item_qty{{$i}}' id='qty{{$items[$i]->id}}' value='1'>
                    <input type='hidden' name="item_qty_{{$i}}" id='qty_{{$items[$i]->id}}' value='1'>
                    <button class='btn btn-default btn-xs' type='button' onclick="addqty('qty{{$items[$i]->id}}','qty_{{$items[$i]->id}}',{{$items[$i]->price_actual}})">+</button>
                    
                    </td>  
                </tr>
               @endfor 
           
           <tr>
        
        <td  colspan=4 align='right'><div class='pull-right'>Total Amount 总价：¥
        <input type='button' class='btn btn-default btn-sm' id='totalamount' value='{{$amount}}'>
        </div></td>
        
        </tr>
        
        </tbody>
        
        
    </table>
    <div class='col-md-offset-4 col-md-6 col-lg-6'>
    	<input class='btn btn-success btn-sm' name='submit' type='submit' value='生成订单'>
    	<a class='btn btn-default btn-sm' href='/clearcart' >清空购物车</a>
    </div>
    </div>
    {{Former::close()}}
    
    @stop
     

              
              
			