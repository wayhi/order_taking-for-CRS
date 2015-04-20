<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Clarins</title>
		@include('assets')
</head>
<body>
{{Former::secure_open()->id('SearchForm')->Method('POST')->route('products.search')}}
<nav class="navbar navbar-inverse" role="navigation">

<div class="container">
 
<div class="navbar-header">

	<div style="color:white;margin:-10px 0 0 0;width:250px;height:20px;float:left">
		<a class="navbar-brand" href="/items"><image src='/images/logo1.png'/></a>
	</div>
</div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

<ul class="nav navbar-nav">


<div class="navbar-form navbar-left" role="search">
<div class="input-group input-group-sm btn-group">
	
<input type="text" class="form-control" style="width:150px" id="sn" name='sn' placeholder="商品名称或SKU Code">


<button type="submit" class="btn btn-danger btn-sm" id="search" name='search' value="s">搜索</button>

</div></div>
<!--li><a href="/activity/create">新建 New Activity</a></li>
<li><a href="/activity">返回 Back</a></li-->
</ul>


<ul class="nav navbar-nav navbar-right huser">

<div class="hum" style='color:#fff'>
当前用户：{{Sentry::getuser()->last_name;}}
 

</div>
</ul>
</div>

</div>

</nav>


<div class='container list'>
  @yield('main')

</div>
<footer class="bs-docs-footer" role="contentinfo">

<div class='container'>
	<hr>
<div class='col-md-6 col-lg-6 text-muted'><p>&copy Clarins {{date('Y')}} </p></div>
</div>
</footer>
{{Former::close()}}
</body>
</html>