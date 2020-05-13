<?php
/**
 * User model
 *
 * Model for interacting with users in the system
 *
 * @author Justin Pohlmann
 */
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * Connected table
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Editable fields
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    public function messages()
    {
        return $this->hasMany('App\Http\Models\Message', 'id', 'sender_id');

    }
}