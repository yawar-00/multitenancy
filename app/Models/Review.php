<?php

namespace App\Models;

use App\Models\ReviewImage;
use App\Models\ProductsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $table= 'reviews';
    protected $guarded =[];



    public function product()
{
    return $this->belongsTo(ProductsModel::class,'product_id');
}
public function images()
{
    return $this->hasMany(ReviewImage::class);
}
}
