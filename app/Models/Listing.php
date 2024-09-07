<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;



    protected $table = "listings";
    protected $guarded=[];

    public function scopeFilter($query, array $filter)
    {
        if($filters["search"] ??  false){
            $query->where("title","like","%". request("search") ."%")
            ->orwhere("description","like","%". request("search") ."%")
            ->orwhere("tags","like","%". request("search") ."%");
        }

    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
