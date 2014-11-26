<?php
class UserTableSeeder extends Seeder {

    public function run()
    {
        // to use non Eloquent-functions we need to unguard
        Eloquent::unguard();

        // All existing users are deleted !!!
        DB::table('user')->delete();

        // add user using Eloquent
        $user = new User;
        $user->firstname = 'Erik';
		$user->lastname = 'Theoboldt';
        $user->email = 'erik@teqneers.de';
        $user->password = Hash::make('admin');
        $user->save();

        // alternativ to eloquent we can also use direct database-methods
        /*
        User::create(array(
            'username'  => 'admin',
            'password'  => Hash::make('password'),
            'email'     => 'admin@localhost'
        ));
        */
    }
}