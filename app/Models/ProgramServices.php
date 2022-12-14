<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramServices extends Model
{
    use HasFactory;
    protected $table = 'library_program_services';
    protected $fillable = ['title', 'description'];
}
