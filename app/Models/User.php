<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone1',
        'phone2',
        'salary',
        'is_admin',
        'shift_work',
        'commission',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservations()
    {
      return $this->hasMany('App\Models\Reservation', 'client_id', 'id');
    }

    public function branchs()
    {
      return $this->hasMany('App\Models\Branch', 'manger_branch', 'id');
    }

    public function user_reservation()
    {
      return $this->hasMany('App\Models\UserResveration', 'user_id', 'id');
    }

    public function invoices()
    {
      return $this->hasMany('App\Models\Invoice', 'created_by', 'id');
    }

    public function commissions()
    {
      return $this->hasMany('App\Models\UserCommission', 'user_id', 'id');
    }

    public function user_branchs()
    {
      return $this->hasMany('App\Models\UserBranch', 'user_id', 'id');
    }

    public function user_branch()
    {
      return $this->hasOne('App\Models\UserBranch', 'user_id', 'id');
    }


}
