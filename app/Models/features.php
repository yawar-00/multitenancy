<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class features extends Model
{
    use HasFactory;
    protected $table='features';
    protected $guarded=[];
    public function plan()
{
    return $this->belongsTo(Plan::class);
}
}
