<?php
Namespace app\controllers;
use View, Sentry,Session, DB, Excel,Redirect,Request,URL,Cookie,User,Notification,Input,Crypt;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$users = Sentry::with('groups')->where('id','>',0)->paginate(15);
		//Debugbar::info($users);
		return View::make('users/index')->with('users',$users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		if(Input::has('submit')){
			if(Input::get('Password')<>Input::get('Password_confirmation')){
				Notification::error('Password and confirmation are NOT the same!');
				return Redirect::back()->withInput();
			}
			try{
			    // Create the user
			    $user = Sentry::createUser(array(
			        'email'     => Input::get('email'),
			        'password'  => Input::get('Password'),
			        'last_name'	=> Input::get('last_name'),
			        'deliver_to' => Input::get('deliver_to'),
			        'quota' => floatval(Input::get('quota')),
			        'activated' => Input::get('activated'),
			    ));

			    // Find the group using the group id
			    $userGroup = Sentry::findGroupById(Input::get('group'));

			    // Assign the group to the user
			    $user->addGroup($userGroup);
	    
				}
				catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
				{
				    Notification::error('Login field is required.');
				    return Redirect::back()->withInput();
				}
				catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
				{
				    Notification::error('Password field is required.');
				    return Redirect::back()->withInput();
				}
				catch (\Cartalyst\Sentry\Users\UserExistsException $e)
				{
				    Notification::error('User with this login already exists.');
				    return Redirect::back()->withInput();
				}
				catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
				{
				    Notification::error('Group was not found.');
				    return Redirect::back()->withInput();
				}
	  
			Notification::success('User '.Input::get('email').(' has been created successfully!') );
			return Redirect::route('users.create');
		}	

		if(Input::has('import')){
			set_time_limit(60);
			$n=0;
			$k=0;
			if(Input::hasFile('attachement')){
				$attached = Input::file('attachement');
				$results = Excel::load($attached)->get();
				
				foreach($results as $row){
					try{
						if($row['email']<>""){

							$user=Sentry::createUser([
								'email' => $row['email'],
								'password' => $row['password'],
								'last_name' => $row['name'],
								'activated'=> true,
								'deliver_to'=> $row['limitation'],
								'quota'=> $row['limitation']
								]);
							$group = Sentry::findGroupById($row['group_id']);
							$user->addGroup($group);
							$n +=1;
						}		
					}catch (\Cartalyst\Sentry\Users\UserExistsException $e)
					{
					    //Notification::error('User '.$row['email'].' with this login already exists.');
					    $user = Sentry::findUserByLogin($row['email']);
					    $user->deliver_to = $row['deliver_to'];
					    $user->quota = $row['limitation'];
					    if($row['status'] == 0){
					    	$user->activated = false;
					    }elseif ($row['status'] == 1) {
					    	$user->activated = true;
					    }
					    //$group = Sentry::findGroupById($row['group_id']);
						//	$user->addGroup($group);
					    $user->save();
					    $k +=1;

					}
					catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
					{
					    Notification::error('Group for User '.$row['email'].' was not found.');
					}
					
				}		
			}
			Notification::success("There are ".$n." user(s) imported into system and ".$k." user(s) updated successfully!");
			return Redirect::route('users.index');	
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
		//
	}
	


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::findUserById(Crypt::decrypt($id));
		if($user){
			$group_id = $user->getGroups()[0]->id;
			return View::make('users/edit')->with('user',$user)->with('group_id',$group_id);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Input::has('submit')){

			$user = Sentry::findUserById(Crypt::decrypt($id));
			$groups = $user->getGroups();
			foreach($groups as $group){

				$user->removeGroup($group);
			}
			$user->last_name = Input::get('last_name');
			$user->activated = Input::get('activated');
			$user->deliver_to = Input::get('deliver_to');
			$user->quota = floatval(Input::get('quota'));
			$user->addGroup(Sentry::findGroupById(Input::get('group')));

			$user->save();
			return Redirect::route('users.index');

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

	public function import()
	{
		return View::make('users/import');

	}

	public function search(){

		if(Request::isMethod('post')){

			if(Input::has('search')){

				$search_string = Input::get('sn');
				if($search_string<>""){
					
					return Redirect::route('users.search_result',['search_term'=>$search_string])->withInput();
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
				
				$users = Sentry::with('groups')
						->where('last_name','like','%'.$search_term.'%')
					->orderby('created_at','desc')->paginate(15);

					
					return View::make('users/search')->with('users',$users)->with('search_string',$search_term);
			}
		}

		



	}

}
