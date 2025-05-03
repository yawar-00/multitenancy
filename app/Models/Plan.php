<?php

namespace App\Models;

use App\Models\features;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $table= 'plans';
    protected $guarded=[];
    
    public function features()
{
    return $this->hasMany(features::class);
}
}
