<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    // One To Many (Inverse)
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }
    
    // One to Many (uno a muchos)
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    // One to Many (uno a muchos)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Validar que solo se pueda dar like una vez
    public function checkLike(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
