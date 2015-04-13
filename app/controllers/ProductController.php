<?php
Namespace app\controllers;
use View, Sentry, Activity, ActivityItem, DB, Crypt,Excel,Redirect,Session,Request,URL,Cookie,Item,ItemSkin,Skin,Notification,Input,Debugbar;


class ProductController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Item::with('category')->where('id','>','0')->orderBy('created_at','desc')->paginate(8);
		return View::make('products/index')->with('products',$products);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('products/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::has('submit')){    //新增单个商品
			
			$item_new = DB::transaction(function(){
			
				$item = new Item();
				$item->SKU_code = Input::get('SKU_code');
				$item->category_id = Input::get('category');
				$item->item_name = Input::get('item_name');
				$item->texture = Input::get('texture');
				$item->description = Input::get('description');
				$item->description_short = Input::get('description_short');
				$item->how_to_use = Input::get('how_to_use');
				$item->size = Input::get('size');
				$item->activated = 1;
				if(Input::hasFile('attachement')) {
					$item->image = Input::file('attachement')[0];
				}
				$item->save();
				if(Input::has('skin_1')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 1;
					$itemskin->save();
				}
				if(Input::has('skin_2')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 2;
					$itemskin->save();
				}
				if(Input::has('skin_3')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 3;
					$itemskin->save();
				}
				if(Input::has('skin_4')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 4;
					$itemskin->save();
				}
				return $item;
			});

		Notification::success('The product "'.$item_new->item_name.'" has been created successfully!');
		return Redirect::route('products.create');
		
		}
		
		if (Input::has('import')) { //批量导入产品
			$n=0;
			if(Input::hasFile('attachement')){

				$attached = Input::file('attachement');
				$results = Excel::load($attached)->get();
				//Debugbar::info($results);
				foreach($results as $row){
					$item = new Item();
					$item->SKU_code = $row['sku_code'];
					$item->category_id = $row["category"];
					$item->item_name = $row["product_name_cn"];
					$item->item_name_2 = $row["product_name_en"];
					$item->texture = $row["texture"];
					$item->description = $row["description"];
					$item->description_short = $row["description_short"];
					$item->how_to_use = $row["how_to_use"];
					$item->size = $row["size"];
					$item->activated = 1;
					$item->save();
					$n +=1;
					/**
					if($row['一般肌肤']==1){
						$itemskin = new ItemSkin();
						$itemskin->item_id = $item->id;
						$itemskin->skin_id = 1;
						$itemskin->save();
					}
					if($row['干性肌肤']==1){
						$itemskin = new ItemSkin();
						$itemskin->item_id = $item->id;
						$itemskin->skin_id = 2;
						$itemskin->save();
					}
					if($row['混合型肌肤']==1){
						$itemskin = new ItemSkin();
						$itemskin->item_id = $item->id;
						$itemskin->skin_id = 3;
						$itemskin->save();
					}
					if($row['油性肌肤']==1){
						$itemskin = new ItemSkin();
						$itemskin->item_id = $item->id;
						$itemskin->skin_id = 4;
						$itemskin->save();
					} 
					**/

				}
				
				if($n>0){
					if($n==1){
						Notification::success("There is 1 product imported into system successfully.");
						return redirect::route("products.index");
					}else{
						Notification::success("There are ".$n." products imported into system successfully.");
						return redirect::route("products.index");
					}
					
				}else{
					Notification::error("There are NO products imported into system successfully.");
					return redirect::route("products.import");
				}
				
			}else{ //no file selected

				Notification::error('Please choose an appropriate Excel file.');
				return redirect::route("products.import");
			}
			
			
		}
		
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$uid = Crypt::decrypt($id);
		$product = Item::find($uid);
		return View::make('products/show')->with('product',$product);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$uid = Crypt::decrypt($id);
		$product = Item::with('skins','category')->find($uid);
		return View::make('products/edit')->with('product',$product);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Input::has('submit')){    //提交表单
			$uid = Crypt::decrypt($id);
			$item = Item::find($uid);
			
				$item->SKU_code = Input::get('SKU_code');
				$item->category_id = Input::get('category');
				$item->item_name = Input::get('item_name');
				$item->texture = Input::get('texture');
				$item->description = Input::get('description');
				$item->description_short = Input::get('description_short');
				$item->how_to_use = Input::get('how_to_use');
				$item->size = Input::get('size');
				$item->activated = 1;
				if(Input::hasFile('attachement')) {
					$item->image = Input::file('attachement')[0];
				}
				$item->save();
				
				ItemSkin::where('item_id',$uid)->delete();

				if(Input::has('skin_1')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 1;
					$itemskin->save();
				}
				if(Input::has('skin_2')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 2;
					$itemskin->save();
				}
				if(Input::has('skin_3')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 3;
					$itemskin->save();
				}
				if(Input::has('skin_4')){
					$itemskin = new ItemSkin();
					$itemskin->item_id = $item->id;
					$itemskin->skin_id = 4;
					$itemskin->save();
				}
			
		
		}
		
		Notification::success('The product information of "'.$item->item_name.'" has been updated successfully!');
		return Redirect::route('products.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function import()
	{



		return View::make('products/import');



	}

	public function search(){

		if(Request::isMethod('post')){

			if(Input::has('search')){

				$search_string = Input::get('sn');
				if($search_string<>""){

					//$products = Item::with('category')
					//	->where('item_name','like','%'.$search_string.'%')
					//	->orWhere('SKU_code',$search_string)
					//->orderby('created_at','desc')->paginate(8);

					
					return Redirect::route('products.search_result',['search_term'=>$search_string])->withInput();
				}else{

					return Redirect::back();
				}


			}
		}
	}
	
	public function search_result($search_term=""){

		if(Request::isMethod('get')){
			//echo "search term=".$search_term;
			if($search_term<>""){
				
				$products = Item::with('category')
						->where('item_name','like','%'.$search_term.'%')
						->orWhere('SKU_code',$search_term)
					->orderby('created_at','desc')->paginate(8);

					
					return View::make('products/search')->with('products',$products)->with('search_string',$search_term);
			}
		}

	}


}
