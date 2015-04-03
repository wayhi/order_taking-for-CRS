@extends('default_user')
@section('main')
 <h2 align='center'>更新用户信息</h2>
    {{ Notification::showAll() }}

{{ Former::secure_open()->id('User')->Method('PUT')->route('users.update',Crypt::encrypt($user->id)) }}

 {{Former::populate($user)}} 
  
<div class="row">
  <div class='col-md-offset-2 col-md-4 col-lg-4'>
    {{Former::text('email','登录Email:')->class('form-control')->disabled()}}
  </div>
  <div class='col-md-4 col-lg-4'> 
    {{Former::text('last_name','用户姓名：')->class('form-control')->required()}}
  </div>
</div>    

<div class='row'>
  <div class='col-md-offset-2 col-md-4 col-lg-4'>
    {{Former::select('group','所属群组：')->fromQuery(Group::all(),'name','id')
    ->class('form-control')->select($group_id)}}
  </div>
  <div class='col-md-4 col-lg-4'>
    {{Former::text('quota','个人单次购买限额(元):')->class('form-control')
    ->inlinehelp('To replace the common rule.')}}
  </div>
  </div>
  <div class='row'>
  <div class='col-md-offset-2 col-md-4 col-lg-4'>
    
    {{Former::radios('activated','')->radios('禁止登录','有效')->inline()}}
    

  </div>
</div>


  

<div class='row'>
  
  
  <div class='col-md-4 col-lg-4'></div>
  

</div>


<hr>
<div class ='row'>
<div class="col-md-offset-4">

            {{ Former::submit('更新')->class('btn btn-success')->name('submit') }}
            <a href="{{URL::route('users.index')}}" class="btn btn-default" role='button'>取消</a>
        </div>
        </div>
   	

	
{{Former::close()}}
@stop