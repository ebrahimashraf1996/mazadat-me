<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "branchs";
    protected $fillable = [
        'name',
        'work_hours_from',
        'work_hours_to',
        'map',
        'address',
        'branch_manger',
        'created_by',
        'updated_by'
    ];

    public function reservations()
    {
      return $this->hasMany('App\Models\Reservation', 'branch_id', 'id');
    }

    public function orders()
    {
      return $this->hasMany('App\Models\Order', 'branch_id', 'id');
    }

    public function time_orders()
    {
      return $this->hasMany('App\Models\TimeOrder', 'branch_id', 'id');
    }

    public function invoice_branchs()
    {
      return $this->hasMany('App\Models\InvoiceBranch', 'branch_id', 'id');
    }

    public function manger()
    {
      return $this->belongsTo('App\Models\User', 'branch_manger', 'id');
    }

    public function user()
    {
      return $this->belongsTo('App\Models\User');
    }

    public function user_branchs()
    {
      return $this->hasMany('App\Models\UserBranch', 'branch_id_id', 'id');
    }
}
