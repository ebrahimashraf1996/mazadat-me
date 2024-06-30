<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'client_id',
        'branch_id',
        'service_id',
        'status',
        'status_reservation',
        'date',
        'time',
        'discount_number',
        'discount_parcent',
        'total_price',
        'count_clients',
        'note',
        'status_paid',
        'created_by',
        'updated_by'
    ];


    public function client()
    {
      return $this->belongsTo('App\Models\Client', 'client_id', 'id');
    }

    public function service()
    {
      return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }

    public function branch()
    {
      return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function user()
    {
      return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function service_reservation()
    {
      return $this->hasMany('App\Models\ServiceReservation', 'reservation_id', 'id');
    }

    public function user_reservation()
    {
      return $this->hasMany('App\Models\UserResveration', 'reservation_id', 'id');
    }

    public function invoice()
    {
      return $this->hasOne('App\Models\Invoice', 'reservation_id', 'id');
    }
}
