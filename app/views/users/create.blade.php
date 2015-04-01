@extends('default_user')
@section('main')
 <h2 align='center'>创建新用户</h2>
    {{ Notification::showAll() }}

{{ Former::secure_open()->id('User')->Method('POST')->route('users.store') }}

  
<div class="row">
  <div class='col-md-offset-2 col-md-4 col-lg-4'>
    {{Former::email('email','登录Email:')->class('form-control')->required()}}
  </div>
  <div class='col-md-4 col-lg-4'> 
    {{Former::text('last_name','用户姓名：')->class('form-control')->required()}}
  </div>
</div>    

<div class='row'>
  <div class='col-md-offset-2 col-md-4 col-lg-4'>
    {{Former::password('Password','密码:')->class('form-control')->required()}}
  </div>
  <div class='col-md-4 col-lg-4'> 
    {{Former::password('Password_confirmation','确认密码:')->class('form-control')->required()}}
  </div>

</div>

<div class='row'>
  <div class='col-md-offset-2 col-md-4 col-lg-4'>
    {{Former::select('group','所属群组：')->fromQuery(Group::all(),'name','id')
    ->class('form-control')}}
  </div>
  <div class='col-md-offset-1 col-md-4 col-lg-4'>
    
    {{Former::radios('activated','')->radios('禁止登录','有效')}}
    

  </div>

</div>



<hr>
<div class ='row'>
<div class="col-md-offset-4">

            {{ Former::submit('新增')->class('btn btn-success')->name('submit') }}
            <a href="{{URL::route('users.index')}}" class="btn btn-default" role='button'>取消</a>
        </div>
        </div>
   	

	
{{Former::close()}}
@stop