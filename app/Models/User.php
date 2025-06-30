<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public $incrementing = true;       // ✅ penting!
    protected $keyType = 'int';        // ✅ pastikan sesuai tipe user_id


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'name',
        'first_name',
        'last_name',
        'username',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'created_by');
    }
    
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'created_by');
    }

    public function banners()
    {
        return $this->hasMany(Banner::class, 'created_by');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'created_by');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'created_by');
    }
}
