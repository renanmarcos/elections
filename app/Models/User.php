<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_number', 'name', 'email', 'password', 'candidate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token', 'created_at', 'updated_at', 'remember_token', 'candidate_id'
    ];

    /**
     * Translate Reset Password notification
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Encrypt password
     */
    public function setPasswordAttribute($password)
    {
        if (!empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    /**
     * Determines if user can create candidate
     *
     * @return true
     */
    public function hasPermissions()
    {
        return $this->document_number == 0;
    }
}
