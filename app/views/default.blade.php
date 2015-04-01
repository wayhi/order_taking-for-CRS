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

<nav class="navbar navbar-inverse" role="navigation">

<div class="container">
 
<div class="navbar-header">

	<div style="color:white;margin:-10px 0 0 0;width:250px;height:20px;float:left">
		<a class="navbar-brand" href="/items"><image src='/images/logo1.png'/></a>
	</div>
</div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

<ul class="nav navbar-nav">

<li class='dropdown'>
 <a href="/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">产品<span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">
<li><a href="{{URL::Route('items.category',['category_id'=>0])}}">所有产品</a></li>
<li><a href="{{URL::Route('items.category',['category_id'=>2])}}">面部护理</a></li>
<li><a href="{{URL::Route('items.category',['category_id'=>3])}}">身体护理</a></li>
<li><a href="{{URL::Route('items.category',['category_id'=>4])}}">男士系列</a></li>
<li><a href="{{URL::Route('items.category',['category_id'=>5])}}">礼品和套装</a></li>
</ul>
</li>
<li class='dropdown'>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">个人<span class="caret"></span></a>

<ul class="dropdown-menu" role="menu">
<li><a href="/orders">订单信息</a></li>
<li><a href="/">账户信息</a></li>
<li><a href="/">修改密码</a></li>

</ul>
</li>
@if(Sentry::getUser()->hasAccess('admin'))
<li class='dropdown'>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">系统<span class="caret"></span></a>

<ul class="dropdown-menu" role="menu">
@if(Sentry::getUser()->hasAccess('HR'))
<li><a href="{{URL::Route('users.index')}}">人员管理</a></li>
@endif
@if(Sentry::getUser()->hasAccess('Operation'))
<li><a href="{{URL::Route('products.index')}}">产品管理</a></li>
<li><a href="{{URL::Route('activity.index')}}">活动管理</a></li>
<li><a href="{{URL::Route('orders.manage',Session::get('activity_id'))}}">订单管理</a></li>
@endif
</ul>
</li>
@endif
<li><a href="/logout">退出</a></li>
</ul>
{{Former::secure_open()->id('SearchForm')->Method('POST')->route('items.search')}}
<div class="navbar-form navbar-left" role="search">
<div class="input-group input-group-sm btn-group">
<input type="text" class="form-control" style="width:150px" id="sn" name='sn' placeholder="商品名称">
<span class="input-group-btn">

<button type="submit" class="btn btn-danger btn-sm" id="search" name='search' value="s">搜索</button>
{{Former::close()}}
<ul class="dropdown-menu" role="menu">
<li>搜索记录</li>
</ul>
</span>
</div>

</div>
<ul class="nav navbar-nav huser">

<div class="hum" style='color:#fff'>
欢迎：{{Sentry::getuser()->last_name;}}
 &nbsp<a href="/showcart">购物车</a>

</div>
</ul>
</div>

</div>

</nav>


<div class='container list'>
  @yield('main')

</div>


</body>
</html>