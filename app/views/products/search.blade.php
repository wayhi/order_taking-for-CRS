@extends('default_product')
@section('main')


<div class='col-md-12 col-lg-12'>
<h2 align='left'>搜索：“{{$search_string}}”</h2><br>
{{ Notification::showAll() }}

<table class="table n_table" >
	
        <thead>
            <tr class='warning'>
                <th></th>
                <th>SKU Code</th>
                <th>产品名称<br>Product Name</th>
                <th>产品类别<br>Product Category</th>
                <th>容量<br>size</th>
                <th>操作<br>Action</th>  
            </tr>
        </thead>
		<tbody>
			@foreach ($products as $product)
			<tr>
			<td>
				@if(!is_null($product->image_file_name))
				<image src="{{$product->image->url('micro')}}">
				@endif
			</td>		
			<td>{{$product->SKU_code}}</td>
			<td><a href="{{URL::Route('products.show',Crypt::encrypt($product->id))}}">{{$product->item_name}}
			<br>{{$product->item_name_2}}
			</a></td>
			<td>{{$product->category->name}}</td>
			<td>{{$product->size}}</td>
			
			<td><a class="btn btn-xs btn-warning" href="{{URL::Route('products.edit',Crypt::encrypt($product->id))}}">更改</a></td>
			</tr>
			
			@endforeach
		</tbody>
</table>		
</div>

<div class='pagination inline'>{{$products->links();}}</div>
<div class='col-md-offset-6'><a class='btn btn-default' href="{{URL::Route('products.index')}}">返回</a></div>
@stop