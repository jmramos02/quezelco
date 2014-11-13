<?php
class UserTableSeeder extends Seeder{

	public function run(){

		for($index = 19; $index <= 1000; ++$index){
			$user = Sentry::register(array(
				'username' => 'consumer'.$index,
				'password' => 'consumer',
				'activated' => '1',
				'first_name' => 'Sample',
				'last_name' => 'Sample',
				'address' => 'Sa gilid ng baste',
				'contact_number' => '09054704478',
			));

			$group = Sentry::findGroupByName('Consumer');
			$user->addGroup($group);

			$user_location = new UserLocation();
			$user_location->user_id = $index;
			$user_location->location_id = $index / 27;
			$user_location->save();
		}
	}
}