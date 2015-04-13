@extends('default_product')
@section('main')
<h2 align='center'>商品详情</h2>
{{ Notification::showAll() }}

 {{ Former::secure_open()->id('ProductForm')->Method('POST')->route('products.update',Crypt::encrypt($product->id))
    	->enctype('multipart/form-data')}}
    	
  {{Former::populate($product)}}  	
<div class="row">
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('SKU_code','SKU')->class('form-control')}}
	</div>
	<div class='col-md-4 col-lg-4'>	
		{{Former::text('item_name','商品名称：')->class('form-control')}}
	</div>
</div>   	

<div class='row'>
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::text('texture','附加信息')->class('form-control')}}
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
		
		{{Former::select('category','产品类别')->fromQuery(Category::all(), 'name', 'id')->class('form-control')->select($product->category->id)}}
	</div>

</div>
<div class='row'>
	
	<div class='col-md-offset-2 col-md-4 col-lg-4'>
		{{Former::textarea('description','描述')->class('form-control')->rows(5)}}
	</div>

	<div class='col-md-4 col-lg-4'>
		{{Former::textarea('how_to_use','使用方法')->class('form-control')->rows(5)}}
	</div>

</div>
<div class='row'>
	<div class='col-md-offset-2 col-md-8 col-lg-8'>
		<br>适用肌肤：
		@foreach($product->skins as $skin)
			{{$skin->type." "}}
		@endforeach
	</div>	
</div>
<div class = 'row'>	

	<div class='col-md-offset-2 col-md-3 col-lg-3'>
	
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
	<div class='col-md-offset-4 col-md-4 col-lg-4'>
		{{ Former::files('attachement')->label('上传图片 ：')->max(5,'MB')}}
	</div>
	
</div>
<hr>
<div class ='row'>
<div class="col-md-offset-5">

            {{ Former::submit('更新')->class('btn btn-success')->name('submit') }}
            <a href="javascript:history.go(-1)" class="btn btn-default">取消</a>
        </div>
        </div>
{{Former::close()}}

@stop