<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = "notes";

    public $fillable = ['content', 'stage_id'];

    public function stage() {
        return $this->belongsTo(AuctionStage::class, 'stage_id', 'id');
    }



}
