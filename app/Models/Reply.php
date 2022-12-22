<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $table = 'reply';
    protected $fillable = ['comment_id', 'user_id', 'message'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
