<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeOrder extends Model
{
  use HasFactory, SoftDeletes;
  protected $fillable = [
      'branch_id',
      'status',
      'date',
      'name',
      'created_by',
      'updated_by'
  ];

  public function branch()
  {
    return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'id');
  }
}
