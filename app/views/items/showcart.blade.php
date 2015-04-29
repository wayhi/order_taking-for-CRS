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
	
	function calculate_amount(q_){
		var t=parseInt(document.getElementsByName('itemcount')[0].value);
        
        
        
        var ttl_amount = 0.00;
        var item_qty = 0;
        var item_price = 0.00;
        var item_qty_o = 0;
        for(var i=0;i<t;i++){
            
            item_qty = parseInt(document.getElementsByName('item_qty'+i)[0].value);
            if (isNaN(item_qty) || item_qty<=0) {

                alert ("请填写正确数值！");
                break;
            }
            document.getElementsByName('item_qty_'+i)[0].value = item_qty;
            item_price = parseFloat(document.getElementsByName('item_price'+i)[0].value);
            //alert(item_price);
            ttl_amount +=  item_price * item_qty;
            //alert(ttl_amount);
        }
	   
       if(ttl_amount > parseFloat(document.getElementById('balance').value)){
          alert("购买总额超过限额！");
          //document.getElementById(q_).focus();
          //break;
        }else{
            document.getElementById('totalamount').value = ttl_amount;
        }
	}

    function show_msg(){
        var msg = "本人申请公司将本次购买产品货款于工资中进行调整。公司有权根据员工申请的调整金额予以最终确认调整比例以及于当月或下月工资进行调整，并作为确定的应税金额。员工清楚，本次申请为员工的真实意思表示，由此可能产生的问题由员工自主承担。员工应清楚自己权利义务后予以慎重申请。请自行下载打印《内买货款调整申请表》";
        if(document.getElementsByName("pmt_method")[0].checked){
            alert(msg);
        }
        
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
                    <input  style="width:50px" name='item_qty{{$i}}' 
                    id='qty{{$items[$i]->id}}' value='1' onblur="calculate_amount('qty{{$items[$i]->id}}')">
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
                {{Former::checkbox('pmt_method','')->text('从本人工资抵扣')->onclick("show_msg();")}}
                <a href="{{URL::route('download_template','内买货款调整申请表.pdf')}}">内买货款调整申请表</a> 
            @elseif($pmt_method == 1)
                <span class='label label-danger' style="font-size:11px">从本人工资抵扣</span>
                <input type='hidden' name='pmt_method' value='1'>
                <a type=hidden name='application' href="{{URL::route('download_template','内买货款调整申请表.pdf')}}">内买货款调整申请表</a> 
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
        <a class='btn btn-default btn-sm' href="{{URL::route('items')}}" >返回</a>
    </div>
    </div>
    {{Former::close()}}
    
    @stop
     

              
              
			