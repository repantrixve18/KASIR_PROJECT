<?php

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'barcode', 'price', 'stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
