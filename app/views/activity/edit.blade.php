@extends('default_activity')
@section('main')
<h2 align='center'>活动详情</h2>
{{ Notification::showAll() }}

 {{ Former::secure_open()->id('ActivityForm')->Method('POST')
 ->route('activity.update',Crypt::encrypt($activity->id))->enctype('multipart/form-data')}}
    	
 {{Former::populate($activity)}}   	
<div class="row">
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('code','活动代码')->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('name','活动名称：')->class('form-control')}}
	</div>
</div>   	

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('start','开始时间')->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('end','结束时间')->class('form-control')}}
	</div>

</div>

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::select('type','活动类型')->options([1=>'Internal Sale',2=>'Free Goods',3=>'Bazzar',])
		->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('amount_limit','限购额度（每用户）¥')->class('form-control')}}
	</div>

</div>
<div class='row'>
	<div class='col-md-offset-2 col-md-8 col-lg-8'>	
		{{Former::textarea('policy','活动规则')->class('form-control')->rows(6)}}
	</div>

</div>	

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{ Former::file('attachement')->label('上传产品目录 ：')->max(5,'MB')}}
	
	
	<a href=''>下载模版</a>
	</div>
	<div class='col-md-4 col-lg-4'>
		{{Former::radios('activated','')->radios('暂停','活动中')->inline()}}
	</div>

</div>


<hr>
<div class ='row'>
<div class="col-md-offset-5">

            {{ Former::submit('更新')->class('btn btn-success')->name('submit') }}
            <a href="{{URL::route('activity.index')}}" class="btn btn-default" role='button'>取消</a>
        </div>
        </div>
{{Former::close()}}

@stop