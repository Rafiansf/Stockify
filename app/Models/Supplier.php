<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Relasi ke model Product
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relasi ke model StockTransaction
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}