@extends('default')
@section('main')
<script language='javascript'>
	function addqty(qty,qty_,price){
		//alert(document.getElementById(e).value);
		document.getElementById(qty).value =parseInt(document.getElementById(qty).value)+1;
		document.getElementById(qty_).value = document.getElementById(qty).value;
		document.getElementById('totalamount').value = 
		parseFloat(document.getElementById('totalamount').value) + parseFloat(price);
        if(parseFloat(document.getElementById('totalamount').value) > parseFloat(document.getElementById('balance').value)){
            
            document.getElementById(qty).value =parseInt(document.getElementById(qty).value)-1;
            document.getElementById(qty_).value = document.getElementById(qty).value;
            document.getElementById('totalamount').value = 
            parseFloat(document.getElementById('totalamount').value) - parseFloat(price);
            alert("购买总额超过限额！");

        }
		
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
{{Former::secure_open()->id('shopping_cart')->Method('POST')->route('orders.create')}}
<div class='col-md-offset-2 col-md-8 col-lg-8'>
<h2><p align='center'>我的购物车</p></h2><br>
<table class=" table n_table" >
	
        <thead>
            <tr>
                
                <th colspan=2 style="vertical-align:middle; text-align:center;">商品 <br> Product
                <input type='hidden' name='itemcount' value='{{$itemcount}}'>
                </th>
                <th style="vertical-align:middle; text-align:center;">单价 <br> Price</th>
                <th style="vertical-align:middle; text-align:center;">数量 <br> Quantity</th>
                <th style="vertical-align:middle; text-align:center;">操作 <br> Action</th>
                
            </tr>
        </thead>
        <tbody>
            
            @for($i=0;$i<$itemcount;$i++)
            	<tr>
                    
                    <td><image src="{{$items[$i]->item->image->url('micro')}}">
                    <input type='hidden' name='item_id{{$i}}' value='{{$items[$i]->item->id}}'>
                    </td>
                    <td style="vertical-align:middle; text-align:left;">{{$items[$i]->item->item_name}}
                    <br><i style="color:grey;">{{$items[$i]->Memo}}</i>
                    </td>
                    <td style="vertical-align:middle; text-align:center;">{{$items[$i]->offer_price}}
                    <input type='hidden' name='item_price{{$i}}' value='{{$items[$i]->offer_price}}'>
                    <input type='hidden' name='item_price_o{{$i}}' value='{{$items[$i]->retail_price}}'>
                    
                    </td>
                    <td style="vertical-align:middle; text-align:center;">
                    <button class='btn btn-default btn-xs' type='button' 
                    onclick="reduceqty('qty{{$items[$i]->id}}','qty_{{$items[$i]->id}}',{{$items[$i]->offer_price}})">-</button>
                    <input type='button' class='btn btn-default btn-xs' name='item_qty{{$i}}' 
                    id='qty{{$items[$i]->id}}' value='1'>
                    <input type='hidden' name="item_qty_{{$i}}" id='qty_{{$items[$i]->id}}' value='1'>
                    <button class='btn btn-default btn-xs' type='button' 
                    onclick="addqty('qty{{$items[$i]->id}}','qty_{{$items[$i]->id}}',{{$items[$i]->offer_price}})">+</button>
                    
                    </td>  
                    <td style="vertical-align:middle; text-align:center;">
                        <a href="{{URL::route('delfrmcart',$items[$i]->id)}}" class='btn btn-default btn-sm'>删除</a>
                    </td>
                </tr>
               @endfor 
           
           <tr>
        
        <td colspan=3 align='center' style="vertical-align:middle;" >
            @if($pmt_method == -1)
                {{Former::checkbox('pmt_method','')->text('从本人工资抵扣')}}
            @elseif($pmt_method == 1)
                <span class='label label-danger' >从本人工资抵扣</span>
                <input type='hidden' name='pmt_method' value='1'>
            @endif    
        </td>
        <td  colspan=2 align='right'>

            <div class='pull-right'>Total Amount 总价：¥
            <input type='button' class='btn btn-default btn-sm' id='totalamount' value='{{$amount}}'>
            <input type='hidden' id='balance' name='balance' value="{{$balance}}">
            </div>
        </td>
        
        </tr>
        
        </tbody>
        
        
    </table>
    <div class='col-md-offset-4 col-md-6 col-lg-6'>

    	<input class='btn btn-success btn-sm' name='submit' type='submit' value='生成订单' 
        @if($amount>$balance || $amount<=0) disabled @endif>
    	<a class='btn btn-warning btn-sm' href='/clearcart' >清空购物车</a>
        <a class='btn btn-default btn-sm' href="{{URL::route('items.index')}}" >返回</a>
    </div>
    </div>
    {{Former::close()}}
    
    @stop
     

              
              
			