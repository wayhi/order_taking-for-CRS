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
		
			$msg = DB::transaction(function(){
				
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

				if(Input::hasFile('attachement'))
					{		
						$attached = Input::file('attachement');

						
						//$results = Excel::load('system/uploads/ccsc1.xlsx')->get()->first();
						$results = Excel::load($attached)->get()->first();
						//Debugbar::info($results);
						$items_not_found = "";
						foreach($results as $row)
						{
							$activity_item = new ActivityItem();
							$activity_item->activity_id = $activity->id;
							$item_id = $this->getItemId($row['item_code']);
							if($item_id===0){
								$items_not_found = $items_not_found.$row['item_code'].",";
							}
							$activity_item->item_id = $item_id;
							$activity_item->MOQ = $row['minimum_order_qty'];
							$activity_item->item_limit = $row['max_order_qty'];
							$activity_item->item_stock = $row['inventory'];
							$activity_item->retail_price = $row['retail_price'];
							$activity_item->offer_price = $row['offer_price'];
							$activity_item->updated_by = Sentry::getUser()->id;
							$activity_item->expiration = $row['expiration']->format('Y-m-d');
							$activity_item->memo = $row['comments'];
							$activity_item->save();
							
						}	
					}

				
				return $items_not_found;
			});
			if($msg<>""){
				Notification::warning('The item(s) "'.$msg.'" has/have NOT been loaded successfully, please check the product setting!');
			}else{
				Notification::success('The Activity - "'.$activity->name.'" has been created successfully!');
			}
			
			return Redirect::route('activity.index');
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
		$a_items = ActivityItem::with('item')->where('activity_id',$uid)->paginate(8);
		return View::make('activity/show')->with(['activity'=>$activity,'a_items'=>$a_items]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{	
		$uid=Crypt::decrypt($id);
		$activity = Activity::with('a_items.item')->find($uid);
		return View::make('activity/edit')->with('activity',$activity);
		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		

		if( Input::has('submit'))
		{	
			
			//$New_activity = DB::transaction(function()
			//{
				
				$uid=Crypt::decrypt($id);
				//Debugbar::info($uid);
				$activity = Activity::find($uid);
				if($activity)
				{
					$activity->code = Input::get('code');
					$activity->name = Input::get('name');
					$activity->start = Input::get('start');
					$activity->end = Input::get('end');
					$activity->type = Input::get('type');
					$activity->amount_limit = floatval(Input::get('amount_limit'));
					$activity->updated_by = Sentry::getUser()->id;
					$activity->activated = Input::get('activated');
					$activity->save();

					$items_not_found = "";
					if(Input::hasFile('attachement'))
					{		
						$attached = Input::file('attachement');
						$existing_items = ActivityItem::where('activity_id',$uid);
						$existing_items->delete();
						
						//$results = Excel::load('system/uploads/ccsc.xlsx')->get()->first();
						$results = Excel::load($attached)->get()->first();
						
						foreach($results as $row)
						{
							$activity_item = new ActivityItem();
							$activity_item->activity_id = $uid;
							$item_id = $this->getItemId($row['item_code']);
							if($item_id===0){
								$items_not_found = $items_not_found.$row['item_code'].",";
							}
							$activity_item->item_id = $item_id;
							
							//$activity_item->item_id = $this->getItemId($row['item_code']);
							$activity_item->MOQ = $row['minimum_order_qty'];
							$activity_item->item_limit = $row['max_order_qty'];
							$activity_item->item_stock = $row['inventory'];
							$activity_item->retail_price = $row['retail_price'];
							$activity_item->offer_price = $row['offer_price'];
							$activity_item->updated_by = Sentry::getUser()->id;
							$activity_item->expiration = $row['expiration']->format('Y-m-d');
							$activity_item->memo = $row['comments'];
							$activity_item->save();
							
						}	
					}
					if($items_not_found == ""){
						Notification::success("The activity information has been updated successfully!");
					}else{
						Notification::warning("The item(s): ".$items_not_found." has/have NOT been loaded successfully,
							please check the product setting!");
					}

					
				}else{

					Notification::error("The activity information has NOT been updated successfully!");

				}	
				//return $activity;
		
			//});
			
			
			return Redirect::route('activity.edit',Crypt::encrypt($activity->id));
		}
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

	private function getItemId($skucode)
	{

		$item = Item::where('SKU_Code','=',$skucode)->first();
		if($item){

			return $item->id;

		}else{

			return 0;
		}
		


	}


}
