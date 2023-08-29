<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'description',
        'price',
        'tags',
    ];

    public function galleries() {
        return $this->hasMany(ProductGallery::class);
    }

    public function productCategory() {
        return $this->belongsTo(ProductCategory::class);
    }
}
