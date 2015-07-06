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
  <div class='col-md-4 col-lg-4'>
    {{Former::text('quota','个人单次购买限额(元):')->class('form-control')->inlinehelp('To replace the common rule.')}}
  </div>
  </div>

  <div class='row'>
    <div class='col-md-offset-2 col-md-8 col-lg-8'>
      {{Former::text('deliver_to','送货地址：')->class('form-control')}}
    </div>  
  </div>

  <div class='row'>
  <div class='col-md-offset-3 col-md-4 col-lg-4'>
    
    {{Former::radios('activated','')->radios('禁止登录','有效')}}
    

  </div>

</div>




<div class ='row'>
<div  align="center">

            {{ Former::submit('新增')->class('btn btn-success')->name('submit') }}
            <a href="{{URL::route('users.index')}}" class="btn btn-default" role='button'>取消</a>
        </div>
        </div>
   	

	
{{Former::close()}}
@stop