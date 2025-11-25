<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use SoftDeletes;
   protected $fillable = [
        'user_id',
        'rental_date',
        'return_date',
        'total_price',
        'status',
        'snap_token',
        
    ];

    // TAMBAHKAN INI (CASTING)
    protected $casts = [
        'rental_date' => 'date',
        'return_date' => 'date',
        'total_price' => 'decimal:2', // Opsional: agar harga jadi angka presisi
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(RentalDetail::class);
    }

    public function items()
    {
        // HAPUS ->withTimestamps() karena tabel rental_details tidak punya kolom waktu
        return $this->belongsToMany(Item::class, 'rental_details', 'rental_id', 'item_id')
                    ->withPivot('quantity', 'subtotal_price'); 
    }
    
}
