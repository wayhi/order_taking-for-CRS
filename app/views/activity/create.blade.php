@extends('default_activity')
@section('main')
<h2 align='center'>创建新的活动</h2>
{{ Notification::showAll() }}

 {{ Former::secure_open()->id('ActivityForm')->Method('POST')->route('activity.store')->enctype('multipart/form-data')}}
    	
    	
<div class="row">
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('code','活动编号:')->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('name','活动名称：')->class('form-control')}}
	</div>
</div>   	

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('start','开始时间:')->class('form-control')->placeholder('YYYY-mm-dd hh:mm:ss')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('end','结束时间:')->class('form-control')->placeholder('YYYY-mm-dd hh:mm:ss')}}
	</div>

</div>

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::select('type','活动类型')->options([1=>'Internal Sale',2=>'Free Goods',3=>'Family Sale',])
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
	
	
	<a href="{{URL::route('download_template','activity_item_template.xlsx')}}">下载模版</a>
	</div>
	<div class='col-md-2 col-lg-2'>
		{{Former::radios('activated','活动中')->checkboxes(0,1)->inline()->check(1)}}
	</div>
	<div class='col-md-2 col-lg-2'>
		{{Former::radios('activated','暂停')->checkboxes(0,1)->inline()->check(0)}}
	</div>

</div>


<hr>
<div class ='row'>
<div class="col-md-offset-4">

            {{ Former::submit('新增')->class('btn btn-success')->name('submit') }}
            <a href="{{URL::route('activity.index')}}" class="btn btn-default" role='button'>取消</a>
        </div>
        </div>
{{Former::close()}}

@stop