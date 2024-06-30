<?php

namespace App\Models;

use App\ModelFilters\AuctionStageFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AuctionStage extends Model
{
    use HasFactory , Filterable;
    protected $guarded = [];
    protected $dates = ['end_time'];

    public function modelFilter()
    {
        return $this->provideFilter(AuctionStageFilter::class);
    }

    /**
     * Scope a query to only include active auction.
    */
    public function scopeAuction(Builder $query): void
    {
        $query->where('auction_id', auth('auction')->user()->id);
    }

    public function getStartTime()
    {
        if($this->start_time){
            return  date('Y-m-d' ,strtotime($this->start_time));
        }
        return date('Y-m-d H:i:s');
    }

    public function getEndTime()
    {
        if($this->end_time){
            return  date('Y-m-d H:i:s' ,strtotime($this->end_time));
        }
        return '';
    }

    public function getStartTimeAsTime()
    {
        return  date('H:i' ,strtotime($this->start_time));
    }

    public function isExpired()
    {
        if($this->end_time  != null && $this->end_time->isPast() ){
            return true;
        }
        return false;
    }

    public function auctionProducts(){
        return $this->hasMany(AuctionProduct::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->auction_id = auth('auction')->user()->id;
        });

        self::updating(function ($model) {
            $model->auction_id = auth('auction')->user()->id;
        });
    }
    public function notes()
    {
        return $this->hasMany(Note::class, 'stage_id', 'id');
    }

}
