<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class Product extends Model // Mendefinisikan class model Product yang mewarisi Eloquent Model
{
    use HasFactory, SoftDeletes; // Menggunakan trait HasFactory dan SoftDeletes

    protected $table = 'products'; // Menentukan nama tabel yang digunakan model ini

    protected $primaryKey = 'product_id'; // Menentukan primary key tabel (default-nya 'id', tapi ini diset 'product_id')

    // Menentukan kolom-kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'product_name',     // Nama produk
        'description',      // Deskripsi produk
        'image_path',       // Path atau lokasi gambar
        'category_id',      // Foreign key untuk relasi ke kategori
        'created_by',       // Foreign key untuk relasi ke user (pembuat produk)
    ];

    // Casting kolom waktu ke instance Carbon (datetime)
    protected $casts = [
        'created_at' => 'datetime', // Kolom created_at dicasting ke format datetime
        'updated_at' => 'datetime', // Kolom updated_at dicasting ke format datetime
        'deleted_at' => 'datetime', // Kolom deleted_at dicasting ke format datetime (digunakan oleh SoftDeletes)
    ];

    // Accessor untuk mengambil URL gambar lengkap, dipanggil sebagai $product->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path); // Jika ada image_path, tampilkan path lengkap ke storage
        }
        return asset('images/no-image.png'); // Jika tidak ada gambar, tampilkan gambar default
    }

    // Relasi: Product dimiliki oleh User (dibuat oleh user tertentu)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by'); // Relasi belongsTo ke model User
    }

    // Relasi: Product termasuk ke dalam satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Relasi belongsTo ke model Category
    }

    // Relasi: Product bisa memiliki banyak komentar dengan morphMany
    public function comments()
    {
        return $this->morphMany(Comment::class, 'target'); // Relasi polymorphic, komentar bisa untuk berbagai model
    }
}
