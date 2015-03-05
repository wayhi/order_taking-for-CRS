<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>easyProcess</title>

  @include('admin._partials.assets')

</head>
<body>
{{ Former::secure_open()->id('change_pwd')->Method('POST')->route('password_confirm')->rules(['Password'=>'confirmed']) }}
  
  <div class="container">
  
  	<div ><h2>重设密码 Reset Password</h2></div>
   
   <hr>     
    
      <div  class="row">
			
			<h4>{{Former::label('需要重设密码的登录账户(Email)：')->class('span6')}}
			{{$Email}}</h4>
			{{Former::text('uid')->type('hidden')->value($uid)}}
			{{Former::text('resetCode')->type('hidden')->value($resetCode)}}
       </div> 
      <br>
		<div  class="row">
			<div class='span6'>
			{{ Former::password('Password')->class('span6')->placeholder('新的登录密码:') }}
			</div>
       </div> 
		<div  class="row">
			<div class='span6'>
				{{ Former::password('Password_confirmation')->class('span6')->placeholder('重复新的登录密码:') }}
			</div>
       </div> 
       <div class="row">
        	<div class='form-actions' >
        	{{ Form::submit('确认密码修改', array('class' => 'btn btn-success btn-login')) }}
        	<a class='btn' href="{{URL::route('login')}}">返回<a/>
        	</div>
    	</div>
    	
    	<br>
       <div  class="row">
      
		{{Notification::showAll();}}
		
		</div>

<hr>

 	
	<div class="footer">
        <p>&copy; easyProcess.cn 2014</p>
      </div>
</div>

</body>
</html>