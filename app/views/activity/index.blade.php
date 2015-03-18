@extends('default_activity')
@section('main')


<div class='col-md-12 col-lg-12'>
<h2 align='center'>所有活动</h2><br>
{{ Notification::showAll() }}

<table class="table n_table" >
	
        <thead>
            <tr>
                <th>活动编号<br>Activity ID</th>
                <th>活动名称<br>Activity Name</th>
                <th>开始时间<br>Commencement </th>
                <th>结束时间<br>Termination</th>
                <th>管理人<br>Updated by</th> 
                <th>更新时间<br>Updated at</th>  
            </tr>
        </thead>
		<tbody>
			@foreach ($activities as $activity)
			<tr>
			<td>{{$activity->id}}</td>
			<td><a href='{{URL::Route('activity.show',Crypt::encrypt($activity->id))}}'>{{$activity->name}}</a></td>
			<td>{{$activity->start}}</td>
			<td>{{$activity->end}}</td>
			<td>{{$activity->updated_by}}</td>
			<td>{{$activity->updated_at}}</td>
			</tr>
			
			@endforeach
		</tbody>
</table>		
</div>
<div class='pagination inline'>{{$activities->links();}}</div>
@stop