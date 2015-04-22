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
		@elseif($activity->type==3) Family Sale
		@endif
		
	</div>
	<div class='col-md-4 col-lg-4'>	
		限购额度（每用户）: ¥{{$activity->amount_limit}}
	</div>

</div>


<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
	活动状态：
	@if($activity->activated==1)
	活动中
	@else 
	暂停
	@endif 
	</div>
</div>

<div class='row'>
	<div class='col-md-offset-2 col-md-8 col-lg-8'>
		<b>活动规则</b>
		<pre>{{{$activity->policy}}}</pre>
	</div>
</div>	
<hr>
<h3 align='center'>供应产品列表</h3>
<div class='row'>
	<div class='col-md-12 col-lg-12'>
		<table class="table n_table" >
			<thead>
				<tr class='warning'>
					<th>产品SKU</th>
					<th>产品名称</th>
					<th>市场价</th>
					<th>优惠价</th>
					<th>供应总量</th>
					<th>最小起订</th>
					<th>最大可供(每人)</th>
					<th>产品有效期</th>
					<th>备注</th>
				</tr>
			</thead>
			<tbody>
			@foreach($a_items as $a_item)
				<tr>
					<td>{{$a_item->item->SKU_code}}</td>
					<td>{{$a_item->item->item_name}}</td>
					<td>{{$a_item->retail_price}}</td>
					<td>{{$a_item->offer_price}}</td>
					<td>{{$a_item->item_stock}}</td>
					<td>{{$a_item->MOQ}}</td>
					<td>{{$a_item->item_limit}}</td>
					<td>{{$a_item->expiration}}</td>
					<td>{{$a_item->Memo}}</td>
				</tr>
			@endforeach	

			</tbody>
		</table>	
		<div class='pagination inline'>{{$a_items->links();}}</div>
	</div>

</div>	
<div class='col-md-offset-6 col-md-6 col-lg-6'>
	
	<a class='btn btn-sm btn-default'  href="{{URL::Route('activity.index')}}">返回</a>
</div>

@stop