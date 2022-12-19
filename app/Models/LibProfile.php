<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibProfile extends Model
{
    use HasFactory;

    protected $table = "library_profile";
    protected $fillable = ['id', 'mission', 'vision', 'rules_regulation', 'school_history'];
}
