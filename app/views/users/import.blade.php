@extends('default_user')
@section('main')
<h2 align='center'>导入用户列表</h2>
{{ Notification::showAll() }}
 {{ Former::secure_open()->id('UserImport')->Method('POST')->route('users.store')
    	->enctype('multipart/form-data')}}
<div class ='row'>
	<div class='col-md-offset-4 col-md-6 col-lg-6'>
		{{ Former::file('attachement')->label('导入文件 ：')->max(5,'MB')}}
	</div>
	
</div>
<div class='row'>
	<div class='col-md-offset-4 col-md-6 col-lg-6'>
		<br>
		<a href="{{URL::route('download_template','userlist_template.xlsx')}}">下载模板</a>
	</div>
</div>

<div class ='row'>
<div class="col-md-offset-5">

            {{ Former::submit('导入')->class('btn btn-success')->name('import') }}
            <a href="{{URL::route('users.index')}}" class="btn btn-default">取消</a>
        </div>
        </div>
{{Former::close()}}
@stop
