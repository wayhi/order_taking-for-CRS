@extends('default_product')
@section('main')
<h2 align='center'>导入产品列表</h2>
{{ Notification::showAll() }}
 {{ Former::secure_open()->id('ProductForm')->Method('POST')->route('products.store')
    	->enctype('multipart/form-data')}}
<div class ='row'>
	<div class='col-md-offset-4 col-md-4 col-lg-4'>
		{{ Former::file('attachement')->label('导入文件 ：')->max(5,'MB')}}
	</div>
	
</div>

<hr>
<div class ='row'>
<div class="col-md-offset-5">

            {{ Former::submit('导入')->class('btn btn-success')->name('import') }}
            <button onclick="javascript:history.go(-1)" class="btn btn-default">取消</button>
        </div>
        </div>
{{Former::close()}}
@stop
