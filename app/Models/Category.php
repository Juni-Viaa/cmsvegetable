<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\SoftDeletes; 

// Class: Category adalah blueprint/kerangka untuk membuat objek kategori
class Category extends Model // Inheritance: Category mewarisi semua properti & method dari Model Laravel
{
    use HasFactory, SoftDeletes; // Trait: mirip mixin dalam OOP untuk menyisipkan method/properti tambahan dari luar class

    // Property: Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'categories';

    // Property: Menentukan nama kolom yang menjadi primary key pada tabel ini
    protected $primaryKey = 'category_id';

    // Property: Array dari atribut yang dapat diisi melalui mass assignment
    protected $fillable = [
        'category_name',  
        'category_type',  
    ];

    // Property: Casting field timestamp ke format DateTime (konsep encapsulation – pembungkus data dengan tipe khusus)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Method: relasi One-to-Many ke model Product (satu kategori memiliki banyak produk)
    // Konsep OOP: method ini mengembalikan relasi antar objek (object relationship)
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id'); 
    }

    // Method: relasi One-to-Many ke model Blog (satu kategori bisa memiliki banyak blog)
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    // Method: relasi One-to-Many ke model Gallery (satu kategori bisa memiliki banyak galeri)
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }
}
