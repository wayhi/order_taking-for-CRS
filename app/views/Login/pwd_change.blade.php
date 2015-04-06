@extends('default_pwd')
@section('main')
{{ Former::secure_open()->id('change_pwd')->Method('POST')->route('password_confirm')->rules(['Password'=>'confirmed']) }}
  
  
  
  	<div ><h2>重设密码 Reset Password</h2></div>
   
   <hr>     
    
      <div  class="row ">
        <div class="col-md-12 col-lg-12">
    			<h4>需要重设密码的登录账户(Email)：{{$Email}}</h4>
    			{{Former::text('uid')->type('hidden')->value($uid)}}
    			{{Former::text('resetCode')->type('hidden')->value($resetCode)}}
         </div> 
       </div>
      <br>
		  <div  class="row">
			<div class='col-md-6 col-lg-6'>
			{{ Former::password('Password')->class('form-control')->placeholder('新的登录密码:') }}
			</div>
       </div> 
		<div  class="row">
			<div class='col-md-6 col-lg-6'>
				{{ Former::password('Password_confirmation')->class('form-control')->placeholder('重复新的登录密码:') }}
			</div>
       </div> 
       <br>
       <div class="row">
        	<div class='col-md-6 col-lg-6' >
        	{{ Form::submit('确认密码修改', array('class' => 'btn btn-success btn-sm')) }}
        	<a class='btn btn-default btn-sm' href="{{URL::route('login')}}">返回<a/>
        	</div>
    	</div>
    	
    	<br>
       <div  class="row">
      
		{{Notification::showAll();}}
		
		</div>

@stop