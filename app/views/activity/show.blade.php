@extends('default_activity')
@section('main')
<h2 align='center'>活动详情</h2>
{{ Notification::showAll() }}

 
    	
    	
<div class="row">
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		活动代码: {{$activity->code}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		活动名称：{{$activity->name}}
	</div>
</div>   	

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		开始时间: {{$activity->start}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		结束时间: {{$activity->end}}
	</div>

</div>

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		活动类型:@if($activity->type==1) Internal Sale
		@elseif($activity->type==2) Free Goods
		@elseif($activity->type==3) Bazzar
		@endif
		
	</div>
	<div class='col-md-4 col-lg-4'>	
		限购额度（每用户）: ¥{{$activity->amount_limit}}
	</div>

</div>


<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
	活动状态：
	@if($activity->activated===1)
	活动中
	@else 
	暂停
	@endif 
	</div>
</div>


<hr>
<h3 align='center'>产品列表</h3>


@stop