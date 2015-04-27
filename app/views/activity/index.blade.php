@extends('default_activity')
@section('main')


<div class='col-md-12 col-lg-12'>
<h2 align='center'>所有活动</h2><br>
{{ Notification::showAll() }}

<table class="table n_table table-striped" >
	
        <thead>
            <tr>
                <th>活动编号<br>Activity Code</th>
                <th>活动名称<br>Activity Name</th>
                <th>开始时间<br>Commencement </th>
                <th>结束时间<br>Termination</th>
                <th>管理人<br>Updated by</th> 
                <th>更新时间<br>Updated at</th>
                <th>活动状态<br>Status</th>
                <th>操作<br>Action</th>  
            </tr>
        </thead>
		<tbody>
			@foreach ($activities as $activity)
			<tr>
			<td>{{$activity->code}}</td>
			<td><a href="{{URL::Route('activity.show',Crypt::encrypt($activity->id))}}">{{$activity->name}}</a></td>
			<td>{{$activity->start}}</td>
			<td>{{$activity->end}}</td>
			<td>{{$activity->creator->last_name}}</td>
			<td>{{$activity->updated_at}}</td>
			<td>
				@if($activity->activated == 0) 
				暂停
				@elseif(($activity->end < date("Y-m-d H:i:s",time())) || ($activity->start) > date("Y-m-d H:i:s",time()))
					不在活动期 
				@else 活动中
				@endif
			</td>
			<td><a class="btn btn-xs btn-warning" href="{{URL::Route('activity.edit',Crypt::encrypt($activity->id))}}">更改</a></td>
			</tr>
			
			@endforeach
		</tbody>
</table>		
</div>

<div class='pagination inline'>{{$activities->links();}}</div>
<div class='col-md-offset-5 col-md-6 col-lg-6'>
	<a class='btn btn-success btn-sm' href="{{URL::route('activity.create')}}">新建</a>
	<a class='btn btn-sm btn-default'  href="{{URL::Route('items.index')}}">返回</a>
</div>
@stop