<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'supplier_id',
        'type',
        'quantity',
        'notes',
        'date',
    ];

    /**
     * Relasi ke model Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => 'Produk Dihapus',
            'code' => '-'
        ]);
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Sistem'
        ]);
    }

    /**
     * Relasi ke model Supplier (Menyelesaikan Error)
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault([
            'name' => '-'
        ]);
    }
}