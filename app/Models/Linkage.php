<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linkage extends Model
{
    use HasFactory;

    protected $table = 'linkages';
    protected $fillable = ['name', 'position', 'school', 'address'];

}
