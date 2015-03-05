<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Clarins</title>
		@include('assets')
		<script>
			$(document.body).on('hidden.bs.modal', function () {
    			$('#myModal').removeData('bs.modal')
			});
			$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
		</script>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     
     
    </div>
  </div>
</div>
<!--end modal -->


<nav class="navbar navbar-inverse" role="navigation">
<div class="container">
 
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="/">CLARINS</a>
</div>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav">

<li><a href="/subs">面部护理</a></li>
<li><a href="/subs/top">身体护理</a></li>
<li><a href="/lists">男士系列</a></li>
<li><a href="/ask">礼品和套装</a></li>

</ul>
<div class="navbar-form navbar-left" role="search">
<div class="input-group input-group-sm btn-group">
<input type="text" class="form-control" style="width:180px" id="sn" placeholder="商品名称">
<span class="input-group-btn">
<button type="button" class="btn btn-danger btn-sm" id="searchbutton" onclick="javascript:search()">搜索商品</button>
<button type="button" class="btn btn-danger dropdown-toggle" style="width:15px;padding-left:3px;" data-toggle="dropdown">
<span class="caret"></span>
<span class="sr-only">Toggle Dropdown</span>
</button>
<ul class="dropdown-menu" role="menu">
<li>搜索记录</li>
</ul>
</span>
</div>

</div>

<ul class="nav navbar-nav navbar-right huser">

<div class="hum">

</div>
</ul>
</div>
</div>
</nav>

<hr>
<div class='container list'>
  @yield('main')

</div>


</body>
</html>