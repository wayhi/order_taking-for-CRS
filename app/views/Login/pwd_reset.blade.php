<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>easyProcess</title>

  @include('admin._partials.assets')

</head>
<body>
{{ Former::secure_open()->id('reset_pwd')->route('email_confirm')->Method('POST') }}
  <!--section class="dark"-->
  <div class="container">
  
  	<div ><h2>重设密码 Reset Password</h2></div>
   
   <hr>     
    
      <div  class="row">
		
		{{Former::text('Email','需要重设密码的登录账户(Email)：')->class('span6')}}
       
       </div> 
      


       <div class="row">
        
        	{{ Form::submit('确认邮件地址', array('class' => 'btn btn-success btn-login')) }}
        	<a class='btn' href="{{URL::route('login')}}">返回<a/>
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