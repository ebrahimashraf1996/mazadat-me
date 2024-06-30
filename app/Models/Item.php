<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'avg_price',
        'provider_id',
        'created_by',
        'updated_by'
    ];

    public function stores()
    {
      return $this->hasMany('App\Models\Store', 'item_id', 'id');
    }

    public function orders()
    {
      return $this->hasMany('App\Models\Order', 'item_id', 'id');
    }

    public function provider()
    {
      return $this->belongsTo('App\Models\Provider', 'provider(_id', 'id');
    }
}
