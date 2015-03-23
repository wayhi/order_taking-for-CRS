@extends('default')
@section('main')
<h2 align='center'>添加新的商品</h2>
{{ Notification::showAll() }}

 {{ Former::secure_open()->id('ItemForm')->Method('POST')->route('items.store')
    	->enctype('multipart/form-data')}}
    	
    	
<div class="row">
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('SKU_code','SKU')->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('item_name','货品名称：')->class('form-control')}}
	</div>
</div>   	

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('texture','质感')->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('size','容量')->class('form-control')}}
	</div>

</div>


<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('description_short','标题')->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::textarea('description','描述')->class('form-control')}}
	</div>

</div>
<div class='row'>
	
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::textarea('how_to_use','使用方法')->class('form-control')}}
	</div>

</div>
<div class = 'row'>	
	<div class='col-md-offset-2 col-md-2 col-lg-2'>
		{{Former::checkboxes('skin_1','一般肌肤')->inline()}}
	</div>
	<div class='col-md-2 col-lg-2'>	
		{{Former::checkboxes('skin_2','干性肌肤')->inline()}}
	</div>
	<div class='col-md-2 col-lg-2'>	
		{{Former::checkboxes('skin_3','混合性肌肤')->inline()}}
	</div>
	<div class='col-md-2 col-lg-2'>	
		{{Former::checkboxes('skin_4','油性肌肤')->inline()}}
	</div>	
		
	</div>
</div>
<div class ='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{ Former::files('attachement')->label('上传图片 ：')->max(5,'MB')}}
	</div>
	
</div>
<hr>
<div class ='row'>
<div class="col-md-offset-4">

            {{ Former::submit('新增')->class('btn btn-success')->name('submit') }}
            <a href="#" class="btn btn-default" role='button'>取消</a>
        </div>
        </div>
{{Former::close()}}

@stop