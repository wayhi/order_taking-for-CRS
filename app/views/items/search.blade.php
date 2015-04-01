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
  搜索：“{{$search_string}}”
</h3>
</div>

<!--div class="pull-right li_menu">
<a href="＃" class="li_menu_a">全部产品</a>　<a href="＃">限购产品</a>　<a href="＃">热销产品</a>
</div-->
</div>
@if(count($items)==0)
<h2 align="center">没有符合条件的结果</h2>
@endif
@for($i=0;$i < count($items);$i=$i+3)
<div class="row">
@for($k=0;($k<3)&&($k+$i < count($items));$k++)
<div class="col-md-4">

<div class="box">
<div class="lb_l">
	<image src="{{$items[$i+$k]->item->image->url('thumbnail')}}" >
	
</div>

<div class="lb_r">
<h4>
<div class="show1">{{$items[$i+$k]->item->category->name}}</div>
 <a href="{{URL::route('items.show',$items[$i+$k]->id)}}" data-toggle="modal" data-target="#myModal">
 {{$items[$i+$k]->item->item_name}}</a>
</h4><br>
<div style="clear:both"></div>
<span class="label label-info">{{$items[$i+$k]->item->size}}</span>
<span class="label label-success">¥ {{$items[$i+$k]->offer_price}}</span> 

@if($items[$i+$k]->item_stock>0)
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


</div><!--end of row-->

@endfor
<div class='pagination inline'>{{$items->links();}}</div>
@stop