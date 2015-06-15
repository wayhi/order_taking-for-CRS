@extends('default_user')
@section('main')


<div class='col-md-12 col-lg-12'>
<h2 align='left'>搜索：“{{$search_string}}”</h2><br>
{{ Notification::showAll() }}

<table class="table n_table" >
	
        <thead>
            <tr class='warning'>
                <th></th>
                <th>ID</th>
                <th>名称<br>Name</th>
                <th>登录邮件地址<br>Email Address</th>
                <th>群组<br>Group</th>
                <th>状态<br>Status</th>
                <th>操作<br>Action</th>  
            </tr>
        </thead>
		<tbody>
			@foreach ($users as $user)
			<tr>
			<td>
			</td>		
			<td>{{$user->id}}</td>
			<td>{{$user->last_name}}</td>
			<td>{{$user->email}}</td>
			<td>{{$user->groups[0]->name}}</td>
			<td>@if($user->activated)有效@else禁止登录@endif</td>
			
			<td><a class="btn btn-xs btn-warning" href="{{URL::Route('users.edit',Crypt::encrypt($user->id))}}">更改</a></td>
			</tr>
			
			@endforeach
		</tbody>
</table>		
</div>

<div class='pagination inline'>{{$users->links();}}</div>
<div class='col-md-offset-5 col-md-6 col-lg-6'>
	
	<a class='btn btn-sm btn-default'  href="{{URL::Route('users.index')}}">返回</a>
</div>
@stop