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
<li><a href="/">面部护理</a></li>
<li><a href="/">身体护理</a></li>
<li><a href="/">男士系列</a></li>
<li><a href="/">礼品和套装</a></li>
</ul>
</li>
<li class='dropdown'>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">个人<span class="caret"></span></a>

<ul class="dropdown-menu" role="menu">
<li><a href="/orders">订单信息</a></li>
<li><a href="/">账户信息</a></li>
<li><a href="/lists">修改密码</a></li>

</ul>
</li>
<li class='dropdown'>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">系统<span class="caret"></span></a>

<ul class="dropdown-menu" role="menu">
<li><a href="/">人员管理</a></li>
<li><a href="/items/create">产品管理</a></li>
<li><a href="/activity">活动管理</a></li>
<li><a href="/">订单管理</a></li>
</ul>
</li>

<li><a href="/logout">退出</a></li>
</ul>

<div class="navbar-form navbar-left" role="search">
<div class="input-group input-group-sm btn-group">
<input type="text" class="form-control" style="width:150px" id="sn" placeholder="商品名称">
<span class="input-group-btn">
<button type="button" class="btn btn-danger btn-sm" id="searchbutton" onclick="javascript:search()">搜索</button>

<ul class="dropdown-menu" role="menu">
<li>搜索记录</li>
</ul>
</span>
</div>

</div>
<ul class="nav navbar-nav huser">

<div class="hum" style='color:#fff'>
当前用户：{{Sentry::getuser()->last_name;}}
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