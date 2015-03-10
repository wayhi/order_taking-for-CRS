@extends('default')
@section('main')

{{ Notification::showAll() }}

<div class="col-md-12">
<div class="pull-left"><h3 style="margin-top:0;">全部产品</h3></div>

<div class="pull-right li_menu">
<a href="＃" class="li_menu_a">全部产品</a>　<a href="＃">限购产品</a>　<a href="＃">热销产品</a>
</div>
</div>

@for($i=0;$i < count($items);$i=$i+3)
<div class="row">
@for($k=0;($k<3)&&($k+$i < count($items));$k++)
<div class="col-md-4">

<div class="box">
<div class="lb_l">
	<image src="{{$items[$i+$k]->image->url('thumbnail')}}" >
	
</div>

<div class="pull-left lb_r">
<h4>
<div class="show1">{{$items[$i+$k]->category->name}}</div> <a href="#" target="_blank">{{$items[$i+$k]->item_name}}</a>
</h4><br>
<div style="clear:both"></div>
<span class="label label-success">¥ {{$items[$i+$k]->price_actual}}</span> 
<!--span class="label label-default">市场价：¥{{$item->price_original}}</span--> 
 
<!--<span class="glyphicon glyphicon-leaf"></span> {{$item->description_short}}<br>
@foreach($item->skins as $skin)
	@if($skin->id==1)
		<span class='label label-info'>{{$skin->type}}</span>
	@elseif($skin->id==2)
		<span class='label label-warning'>{{$skin->type}}</span>
	@elseif($skin->id==3)
		<span class='label label-primary'>{{$skin->type}}</span>
	@elseif($skin->id==4)
		<span class='label label-danger'>{{$skin->type}}</span>		
	@endif
@endforeach
-->
<!--
<span class="label label-info">{{$item->size}}</span> <span class="label label-success">{{$item->texture}}</span>
 <span class="label label-default">市场价：¥{{$item->price_original}}</span> 
 <span class="label label-danger">现价：¥{{$item->price_actual}}</span> 
 @if($item->limit>0)<span class="label label-warning">限购 {{$item->limit}} 件</span> @endif 
 @if($item->activated==1)<span class="label label-success">剩余{{$item->qty}}件</span>@endif
 <br>
 -->
<!--产品有效期：{{($item->expiration)}}-->
@if($items[$i+$k]->activated==1)
<div class='pull-right'>

<a href="{{URL::route('items.addtocart',['id'=>$items[$i+$k]->id,'page'=>Input::get('page')])}}"> 
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




@endfor
<div class='pagination inline'>{{$items->links();}}</div>
@stop