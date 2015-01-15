<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    /**
     * Defines the name of the admin role in database
     */
    const ROLE_ADMIN = 'admin';
    /**
     * Defines the name of the user role in database
     */
    const ROLE_USER = 'user';
    /**
     * Defines the name of the admin role in database
     */
    const TITLE_MALE = 'Herr';
    /**
     * Defines the name of the user role in database
     */
    const TITLE_FEMALE = 'Frau';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * Primary key of a user
	 *
	 * @var string
	 */
	protected $primaryKey = 'uid';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    public function isAdmin()
    {
        return ($this->role == self::ROLE_ADMIN);
    }

    public function isLastAdmin()
    {

            if(DB::table('user')->where('role', self::ROLE_ADMIN)->count()==1){
                return true;
            }



        return false;
    }

    public function isCurrentUser($uid)
    {
        return ($this->uid == $uid);
    }

}
