<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

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
	 * Contains the fields of the model which are dates
	 *
	 * @return array
	 */
	public function getDates()
    {
        return array('last_login', 'deleted_at', 'created_at', 'updated_at');
    }


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

        static::deleting(function($entity)
        {
            $entity->deleted_by = Auth::user()->uid;
        });

		static::restoring(function($entity)
        {
            $entity->deleted_by = null;
        });
    }


    public function isCurrentUser($uid)
    {
        return ($this->uid == $uid);
    }


    /**
     * Check if the given email is active at a user (or inactive)
     *
     * @param   string      $email      Email address to search
     * @param   boolean     $active     If set to true search for users which are currently active (not deleted)
     * @return  string
     */
    public static function uidByEmail($email, $active = true) {
        $count  = DB::table('user')->select('uid')->where('email','=', $email);

        if ($active) {
            $count->whereNull('deleted_by');
        } else {
            $count->whereNotNull('deleted_by');
        }
        $result = $count->get();

        if (count($result) == 0) {
            return 0;
        } elseif (count($result) > 1) {
            return false;
        } else {
            return $result[0]->uid;
        }
    }
}
