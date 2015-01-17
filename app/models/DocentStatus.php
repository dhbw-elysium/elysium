<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class DocentStatus extends Eloquent implements RemindableInterface {

	use RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'docent_status';

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'dsid';

    /**
	 * Mass assignable columns
	 *
	 * @var array
	 */
	protected $fillable	= array(
		'comment'
	);

	public function docent()
    {
        return $this->belongsTo('Docent');
    }

	public function status()
    {
        return $this->belongsTo('Status');
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

}
