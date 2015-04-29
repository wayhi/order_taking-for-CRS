<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Clarins</title>

  @include('assets')

</head>
<body>
  {{ Former::open()->class('form-horizontal')}}
  
  
  <nav class="navbar navbar-inverse" role="navigation">
<div class="container">

 
<div class="navbar-header">

  <div style="color:white;margin:5px 0 0 0;width:250px;height:20px;float:left">
    <image src='/images/logo1.png'/>
  </div>
</div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

<ul class="nav navbar-nav">




</ul>



</div>

</div>

</nav>
   
   
   <div class="container"> 
    <hr>
  <div class='row'>
    <div  class="col-md-5 col-lg-5">
          
          {{ Former::email('email', 'Email: ')->placeholder('登录邮箱')->class('form-control') }}
            
    </div>
  </div>  
  <div class='row'>
    <div  class="col-md-5 col-lg-5">      

       {{ Former::password('password','Password: ')->placeholder('登录密码')->class('form-control') }}
        
    </div>
  </div>
  
  <div class='row'>      
    <div class='col-md-5 col-lg-5'>
          <label class=" checkbox">
            <input type="checkbox" id='remember_me' name='remember_me' value='1'> 记住我的登录
            <a href="{{URL::route('Login.pwd_reset')}}">忘记密码？</a>
          </label>
          <br>
    </div>
  </div>

  <div class='row'>  
    <div class='col-md-12 col-lg-12'>
  	  @if ($errors->has('login'))

          <div class="alert alert-danger">{{ $errors->first('login', ':message') }}</div>
        
        @endif
        
        {{Notification::showAll()}}<br>
    </div>
  </div>
  <div class='row'>
      <div class='col-md-5 col-lg-5'>
        
        {{ Form::submit('登录', array('class' => 'btn btn-success btn-login')) }}
        
      </div>
   </div> 


<hr>

 	
	<div class="footer">
        <p>&copy; Clarins 2015</p>
      </div>
     
</div>

{{former::close()}}

</body>
</html>