<?php

class SentrySeeder extends Seeder {

  public function run()
  {
    DB::table('users')->delete();
    DB::table('groups')->delete();
    DB::table('users_groups')->delete();
 
    Sentry::getUserProvider()->create(array(
      'email'      => 'james.wang@ylbiz-consulting.com',
      'password'   => "checkin",
      'first_name' => 'James',
      'last_name'  => 'Wang',
      'activated'  => 1,
    ));
 
    Sentry::getGroupProvider()->create(array(
      'name'        => 'Admin',
      'permissions' => ['admin' => 1],
    ));
 
    // 将用户加入用户组
    $adminUser  = Sentry::getUserProvider()->findByLogin('james.wang@ylbiz-consulting.com');
    $adminGroup = Sentry::getGroupProvider()->findByName('Admin');
    $adminUser->addGroup($adminGroup);
  }
}