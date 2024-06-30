<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryFinance extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'finance_category';
    protected $fillable = [
        'name',
        'icon',
        'sub_of',
        'created_by',
        'updated_by'
    ];

    public function cashs()
    {
      return $this->hasMany('App\Models\FinanceCash', 'finance_category_id', 'id');
    }
}
