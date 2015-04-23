@extends('default_product')
@section('main')
  
  <h2 align='center'>产品介绍</h2>

 

<div class="box">
<div class="pull-left lb_l">
	<image src="{{$product->image->url('original')}}" >
</div>
<div class="pull-left ">
<h4>

@if($product->category->id==2)
<div class="cat_green">
@elseif($product->category->id==3)
<div class="cat_milk">
@elseif($product->category->id==4)
<div class="cat_blue">
@elseif($product->category->id==5)
<div class="cat_red">
@else <div>
@endif
{{$product->category->name}}</div>

 {{$product->item_name}}
<br>
 {{$product->item_name_2}}
</h4>
<div style="clear:both"></div>
<span class="glyphicon glyphicon-leaf"></span> {{$product->description_short}}<br>

<b style="color:blue">产品介绍：</b>{{$product->description}}<br>
<b style="color:blue">用法：</b>{{$product->how_to_use}}<br>
@foreach($product->skins as $skin)
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
<span class="label label-info">{{$product->size}}</span> <span class="label label-success">{{$product->texture}}</span>
 
<br>

</div>
<div style="clear:both"> </div>

</div>

<div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="javascript:history.go(-1)">Close</button>
        
      </div>


@stop