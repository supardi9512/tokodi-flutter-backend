<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'url',
    ];

    /**
     * Get the product gallery's url.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => config('app.url') . Storage::url($value),
        );
    }
}
