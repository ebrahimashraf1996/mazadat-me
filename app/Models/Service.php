<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'avg_price',
        'time',
        'created_by',
        'updated_by'
    ];

    public function reservations()
    {
      return $this->hasMany('App\Models\Reservation', 'service_id', 'id');
    }

    public function service_reservation()
    {
      return $this->hasMany('App\Models\ServiceReservation', 'service_id', 'id');
    }


}
