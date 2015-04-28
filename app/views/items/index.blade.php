@extends('default')
@section('main')
<script>
$(document.body).on('hidden.bs.modal', function () {
    $('#myModal').removeData('bs.modal');
});

//Edit SL: more universal
$(document).on('hidden.bs.modal', function (e) {
	//$(e.target).removeData('bs.modal').html(''); 
    $(e.target).removeData('bs.modal');
    //$(e.target).html('');
});	
</script>
{{ Notification::showAll() }}
<div  id='myModal' class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="col-md-12">
<div class="pull-left"><h3 style="margin-top:0;">
  {{Category::find($category)->name}} <a style="font-size: 10px" href="{{URL::route('items',['ordertype'=>1,'category'=>$category])}}">价格从高到底</a>
</h3>
</div>

<!--div class="pull-right li_menu">
<a href="＃" class="li_menu_a">全部产品</a>　<a href="＃">限购产品</a>　<a href="＃">热销产品</a>
</div-->
</div>

@for($i=0;$i < count($items);$i=$i+3)
<div class="row">
@for($k=0;($k<3)&&($k+$i < count($items));$k++)
<div class="col-md-4">

<div class="box">
<div class="pull-left">
  {{$items[$i+$k]->Memo}}
</div>
<div class='pull-right'>
{{$items[$i+$k]->item->SKU_code}}
</div>
<div class="lb_l">
	<image src="{{$items[$i+$k]->item->image->url('thumbnail')}}" >
	
</div>

<div >
<h4>
 @if($items[$i+$k]->item->category->id==2)
    <div class="cat_green">{{$items[$i+$k]->item->category->name}}</div>
 @elseif($items[$i+$k]->item->category->id==3)
 <div class="cat_milk">{{$items[$i+$k]->item->category->name}}</div>
 @elseif($items[$i+$k]->item->category->id==4)
 <div class="cat_blue">{{$items[$i+$k]->item->category->name}}</div>
 @elseif($items[$i+$k]->item->category->id==5)
 <div class="cat_red">{{$items[$i+$k]->item->category->name}}</div>
 @endif

 <a style='font-size:11px' href="{{URL::route('items.show',$items[$i+$k]->id)}}" data-toggle="modal" data-target="#myModal">
 {{$items[$i+$k]->item->item_name}}<br>
 {{$items[$i+$k]->item->item_name_2}}</a>
</h4><br>
<div style="clear:both"></div>
<span class="label label-success">{{$items[$i+$k]->item->texture}}</span>
<span class="label label-info">{{$items[$i+$k]->item->size}}</span>
<span class='label label-primary'>剩余：{{($items[$i+$k]->item_stock - $items[$i+$k]->ordered)}} 件</span>
<br>
<span class="label label-default">市场价{{$items[$i+$k]->retail_price}}</span>
<span class="label label-danger" style="font-size:11px">现价{{$items[$i+$k]->offer_price}}</span> 

<br>
产品有效期：{{($items[$i+$k]->expiration)}}
@if($items[$i+$k]->item_stock>$items[$i+$k]->ordered)
<div class='pull-right'>

<a href="{{URL::route('items.addtocart',['id'=>$items[$i+$k]->id,'backurl'=>Crypt::encrypt(URL::full())])}}"> 
<span class="glyphicon glyphicon-shopping-cart"></span> 加入购物车</a>

</div>
@else
<div class='pull-right'>
售罄
</div>
@endif
</div>
<div style="clear:both"> </div>

</div><!--end of box-->

</div><!--end of col-->

@endfor


</div><!--end of row-->

@endfor
<div class='pagination inline'>{{$items->links();}}</div>
@stop