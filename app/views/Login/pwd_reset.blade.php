@extends('default_pwd')
@section('main')
{{ Former::secure_open()->id('reset_pwd')->Method('POST') }}
  
  
  
  	<div ><h2>重设密码 Reset Password</h2></div>
   
   <hr>     
    
      <div  class="row">
    		<div class='col-md-6 col-lg-6'>
          {{Former::text('Email','需要重设密码的登录账户(Email)：')->class('form-control')}}
        </div>
		  </div> 
      
<br>

       <div class="row">
        <div class='col-md-6 col-lg-6'>
        	{{ Form::submit('确认', array('class' => 'btn btn-success btn-sm')) }}
        	<a class='btn btn-default btn-sm' href="{{URL::route('login')}}">返回<a/>
         </div> 
    	</div>
    	
    	<br>
    	
       	<div  class="row">
      
		{{Notification::showAll();}}
		
		</div>
{{Former::close()}}
@stop