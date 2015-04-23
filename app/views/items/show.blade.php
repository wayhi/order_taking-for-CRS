
 <div class="modal-header">
        <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">产品介绍</h4>
</div>
 
<div class="box">
<div class="pull-left lb_l">
	<image src="{{$item->item->image->url('original')}}" >
</div>
<div class="pull-left ">
<h4>

@if($item->item->category->id==2)
    <div class="cat_green">{{$item->item->category->name}}</div>
 @elseif($item->item->category->id==3)
 <div class="cat_milk">{{$item->item->category->name}}</div>
 @elseif($item->item->category->id==4)
 <div class="cat_blue">{{$item->item->category->name}}</div>
 @elseif($item->item->category->id==5)
 <div class="cat_red">{{$item->item->category->name}}</div>
 @endif

{{$item->item->item_name}}<br><b style="font-size:6px">
 {{$item->item->item_name_2}}</b>
</h4>
<div style="clear:both"></div>
<span class="glyphicon glyphicon-leaf"></span> {{$item->item->description_short}}<br>

<b>产品介绍：</b>{{$item->item->description}}<br>
<b>用法：</b>{{$item->item->how_to_use}}<br>

<span class="label label-info">{{$item->item->size}}</span> <span class="label label-success">{{$item->item->texture}}</span>
 <span class="label label-default">市场价：¥{{$item->retail_price}}</span> 
 <span class="label label-danger">现价：¥{{$item->offer_price}}</span> 
 @if($item->item_limit>0)<span class="label label-warning">限购 {{$item->item_limit}} 件</span> @endif 
 
 <br>
 产品有效期：{{$item->expiration}}
<br>

</div>
<div style="clear:both"> </div>

</div>

<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>


