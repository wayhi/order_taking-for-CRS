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
		
		$users = Sentry::with('groups')->where('id','>',0)->paginate(10);
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
			if(Input::hasFile('attachement')){
				$attached = Input::file('attachement');
				$results = Excel::load($attached)->get();
				$n=0;
				foreach($results as $row){
					try{
						$user=Sentry::createUser([
							'email' => $row['email'],
							'password' => $row['password'],
							'last_name' => $row['name'],
							'activated'=> true,
							]);
						$group = Sentry::findGroupById($row['group_id']);
						$user->addGroup($group);
						$n +=1;

					}catch (\Cartalyst\Sentry\Users\UserExistsException $e)
					{
					    Notification::error('User '.$row['email'].' with this login already exists.');
					}
					catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
					{
					    Notification::error('Group for User '.$row['email'].' was not found.');
					}
					
				}		
			}
			Notification::success("There are ".$n." users imported into system successfully!");
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

}
