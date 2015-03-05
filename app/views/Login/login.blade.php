<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Clarins</title>

  @include('assets')

</head>
<body>

  <div class="container">
  
  <div style="color:white;background:url('../images/bg.png')" class="jumbotron">
        
        <div style="color:white;display:block;margin:40px 0 0 0;width:261px;height:40px;float:left">
        <a href='#'>
        <image  src='../images/logo1.png' />
        </a>
        </div>
        <h1>Internal Shop</h1>
   </div>
   
   <hr>     
    {{ Former::open()->class('form-horizontal')}}
      <div class='row'>
      <div  class="form-group col-sm-5">
        
        
         
 {{ Former::email('email', 'Email: ')->placeholder('登录邮箱')->class('form-control col-sm-5') }}
          
         
         <br>
        
 {{ Former::password('password','Password: ')->placeholder('登录密码')->class('form-control col-sm-5') }}
        
        </div>
        </div>
        
        <div class='row'>
        <label class=" checkbox">
          <input type="checkbox" id='remember_me' name='remember_me' value='1'> 记住我的登录
          <a href="#">忘记密码？</a>
        </label>
        <br>
      </div>
<div class='row'>
	  @if ($errors->has('login'))

        <div class="alert alert-error">{{ $errors->first('login', ':message') }}</div>
      
      @endif
</div>

      <div class='row'>
        
        {{ Form::submit('登录', array('class' => 'btn btn-success btn-login')) }}
        
      </div>
    

{{former::close()}}
<hr>

 	
	<div class="footer">
        <p>&copy; Clarins 2015</p>
      </div>
     
</div>



</body>
</html>