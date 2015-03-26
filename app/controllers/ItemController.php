<?php
Namespace app\controllers;
use View, Sentry, DB, Redirect,Session,Request,URL,Cookie,Item,ActivityItem,ItemSkin,Skin,Notification,Input,Debugbar;
class ItemController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$items = Item::with('skins')->with('category')->orderby('created_at','desc')->paginate(9);
		$activity_id = Session::get('activity_id');
		$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)->orderby('created_at','desc')->paginate(9);
		return \View::make('items/index')->with('items',$items);
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('items/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
	
		if(Input::has('submit')){    //提交表单
			
			$item_new = DB::transaction(function(){
			
				$item = new Item();
				$item->SKU_code = Input::get('SKU_code');
				$item->category_id = 0;
				$item->item_name = Input::get('item_name');
				$item->texture = Input::get('texture');
				$item->description = Input::get('description');
				$item->description_short = Input::get('description_short');
				$item->how_to_use = Input::get('how_to_use');
				//$item->price_original = Input::get('price_original');
				//$item->price_actual = Input::get('price_actual');
				$item->size = Input::get('size');
				//$item->qty = Input::get('qty');
				//$item->expiration = Input::get('expiration');
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
		
		}
		
		Notification::success('The product "'.$item_new->item_name.'" has been created successfully!');
		return Redirect::route('items.create');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//$item=Item::find($id);
		$item=ActivityItem::with('item.category')->find($id);
		return View::make('items/show')->with('item',$item);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
	
	public function showcart(){
		$item_id = Cookie::get('item_id');
		$itemcount = 0;
		$items =null;
		$amount = 0.00;
		
		if(is_array($item_id) ){
			$item_id = array_unique($item_id);
			$itemcount = count($item_id);
			if($itemcount>0){
				$items = ActivityItem::with('item')->whereIn('id',$item_id)->get();
				$amount = ActivityItem::whereIn('id',$item_id)->select(DB::raw('sum(offer_price) as amount'))->pluck('amount');
			}
			
		}
		
		
		Debugbar::info($item_id);
		//$itemcount=1;
		
		//Debugbar::info($items);
		
		return View::make('items/showcart')->with('items',$items)->with('amount',$amount)->with('itemcount',$itemcount);
	
	}
	
	public function clearcart(){
		$cookie = Cookie::forget('item_id');
		return redirect::route('showcart')->withCookie($cookie);
	}

	public function addtocart($item_id,$page=1){
		$item = ActivityItem::with('item')->find($item_id);
		$items_exist = Cookie::get('item_id');
		if(($items_exist)==null){
			$items_exist=[];
			//$items = array_add($items_exist,1,$item_id);
		}
		$items = array_add($items_exist,count($items_exist),$item_id);
		
		
		$cookie = Cookie::make('item_id',array_unique($items), 7200);

		Notification::success($item->item->item_name.'已加入您的购物车。');
		//Debugbar::info($url);
		return Redirect::route('items.index',['page'=>$page])->withCookie($cookie);
	
	}

	public function delfrmcart($item_id)
	{

		$item_list= Cookie::get('item_id');
		//Debugbar::info($item_list);
		
		if(is_array($item_list)){

				$keys = array_keys($item_list,$item_id);
				//Debugbar::info($keys);
				foreach($keys as $key){
					array_splice($item_list, $key, 1);

				}
				//Debugbar::info($item_list);

		}else{



		}

		$cookie = Cookie::make('item_id',$item_list, 7200);
		return Redirect::route('showcart')->withCookie($cookie)->withinput();
		//return View::make('items/showcart');
	




	}
}
