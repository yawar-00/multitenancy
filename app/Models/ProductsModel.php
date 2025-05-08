<?php

namespace App\Models;

use App\Models\Review;
use App\Models\category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'description', 'image','category_id','price'];
    public function category(){
        return $this->belongsTo(category::class,'category_id');
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
}
