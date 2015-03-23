<?php
Namespace app\controllers;
use View, Sentry, Activity, ActivityItem, DB, Crypt,Excel,Redirect,Request,URL,Cookie,Item,ItemSkin,Skin,Notification,Input,Debugbar;


class ActivityController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$activities = Activity::with('creator')->orderBy('created_at','desc')->paginate(10);
		return View::make('activity/index')->with('activities',$activities);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('activity/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::has('submit'))
		{	
		
			$New_activity = DB::transaction(function(){
				
				$activity = New Activity();
				$activity->code = Input::get('code');
				$activity->name = Input::get('name');
				$activity->start = Input::get('start');
				$activity->end = Input::get('end');
				$activity->type = Input::get('type');
				$activity->amount_limit = floatval(Input::get('amount_limit'));
				$activity->updated_by = Sentry::getUser()->id;
				$activity->activated = Input::get('activated');
				$activity->save();

				
				$results = Excel::load('system/uploads/ccsc.xlsx')->get()->first();
				foreach($results as $row)
				{
					$activity_item = new ActivityItem();
					$activity_item->activity_id = $activity->id;
					$activity_item->item_id = 0;
					Debugbar::info($row);
					$activity_item->item_limit = $row['order_qty'];
					$activity_item->item_stock = $row['amount_price'];
					$activity_item->retail_price = $row['retail_price'];
					$activity_item->offer_price = $row['offer_price'];
					$activity_item->save();
					
				}	
			});
			return Redirect::route(activity.index);
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
		$uid=Crypt::decrypt($id);
		$activity = Activity::find($uid);
		return View::make('activity/show')->with('activity',$activity);
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


}
