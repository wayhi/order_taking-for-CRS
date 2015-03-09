@extends('default')
@section('main')

<div class="box">
<div class="pull-left lb_l">
	<image src="{{$item->image->url('original')}}" >
</div>
<div class="pull-left lb_r">
<h4>
<div class="show1">{{$item->category->name}}</div> <a href="#" target="_blank">{{$item->item_name}}</a>
</h4>
<div style="clear:both"></div>
<span class="glyphicon glyphicon-leaf"></span> {{$item->description_short}}<br>

<br>

用法：{{}}

<span class="label label-info">{{$item->size}}</span> <span class="label label-success">{{$item->texture}}</span>
 <span class="label label-default">市场价：¥{{$item->price_original}}</span> 
 <span class="label label-danger">现价：¥{{$item->price_actual}}</span> 
 @if($item->limit>0)<span class="label label-warning">限购 {{$item->limit}} 件</span> @endif 
 @if($item->activated==1)<span class="label label-success">剩余{{$item->qty}}件</span>@endif
 <br>
<br><br><br><br><br><br><br><br><br><br><br><br>

</div>
<div style="clear:both"> </div>

</div>




@stop