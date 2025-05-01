<?php

namespace App\Models;

use App\Models\ProductsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['category_name'];
    public function product(){
        return $this->hasMany(ProductsModel::class,'category_id');
    }
}
