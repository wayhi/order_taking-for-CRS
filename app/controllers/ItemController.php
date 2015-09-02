<?php
Namespace app\controllers;
use View, Sentry, User,DB, Redirect,Session,Request,URL,Cookie,Item, Order, Activity,ActivityItem,ItemSkin,Skin,Notification,Input;
class ItemController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($ordertype=0,$category=0)
	{
		$activity_id = Session::get('activity_id');
		$activity = Activity::find($activity_id);
		$activity_type = $activity->type;
		if($ordertype == 0){
			$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)->orderby('id','aesc')->paginate(9);
		}else{
			
			if($category<>0){
				$items = ActivityItem::with('item.category')
				->whereraw("item_id in (select id from ccsc_item_master where category_id = ".$category.")")
				->where('activity_id',$activity_id)
				->orderby('offer_price','desc')->paginate(9);
				
			}else{
				$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)->orderby('offer_price','desc')->paginate(9);
			}	
		}
		
			return \View::make('items/index')->with('items',$items)->with('category',$category)->with('activity_type',$activity_type);
			
		
	}

	public function category($category_id=0)
	{
		$activity_id = Session::get('activity_id');

		if($category_id==0){
			
			$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)
			->orderby('id','aesc')->paginate(9);
			return \View::make('items/index')->with('items',$items)->with('category',0);
		
		}else{

			$items = ActivityItem::with('item.category')
			->whereraw("item_id in (select id from ccsc_item_master where category_id = ".$category_id.")")
			->where('activity_id',$activity_id)
			->orderby('id','aesc')->paginate(9);
			return \View::make('items/index')->with('items',$items)->with('category',$category_id);
			
		}

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
	
	

	public function search($search_term)
	{
		//if(Input::has('search')){

			//$search_string = Input::get('sn');
			if($search_term<>""){

				$activity_id = Session::get('activity_id');
				$activity = Activity::find($activity_id);
				$activity_type = $activity->type;
				$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)
				->whereIn('item_id',count(Item::where('item_name','like','%'.$search_term.'%')->orWhere('SKU_code',$search_term)->lists('id'))==0?[-1]:(Item::where('item_name','like','%'.$search_term.'%')
					->orWhere('SKU_code',$search_term)
					->lists('id')))
				->orderby('created_at','desc')->paginate(9);

				return \View::make('items/search')->with('items',$items)->with('search_string',$search_term)->with('activity_type',$activity_type);
			}else{
				return Redirect::back();
			}

		//}else{

		//	return Redirect::back();

		//}


	}



	
}
