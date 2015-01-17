<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Defines the name of the admin role in database
     */
    const ROLE_ADMIN = 'admin';
    /**
     * Defines the name of the user role in database
     */
    const ROLE_USER = 'user';
    /**
     * Defines the name of the title for a male person
     */
    const TITLE_MALE = 'Herr';
    /**
     * Defines the name of the title of a female person
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

    /**
	 * Add the event listeners to this model
	 */
	public static function boot()
    {
        parent::boot();

        static::creating(function($entity)
        {
            $entity->created_by = Auth::user()->uid;
            $entity->updated_by = Auth::user()->uid;
        });

        static::updating(function($entity)
        {
            $entity->updated_by = Auth::user()->uid;
        });
    }


    public function isCurrentUser($uid)
    {
        return ($this->uid == $uid);
    }

}
