<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewImage extends Model
{
    use HasFactory;
    protected $table='review_images';
    protected $guarded=[];
    public function review()
{
    return $this->belongsTo(Review::class);
}

}
