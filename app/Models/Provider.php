<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;
    protected $table = 'providers';
    protected $fillable = [
        'name',
        'email',
        'phone1',
        'phone2',
    ];

    public function stores()
    {
      return $this->hasMany('App\Models\Store', 'provider_id', 'id');
    }

    public function items()
    {
      return $this->hasMany('App\Models\Item', 'provider_id', 'id');
    }
}
