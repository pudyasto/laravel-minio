<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploader extends Model
{
    use HasFactory;
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',

        'mime',
        'ext',
        'size',
        
        'location',
    ];

    protected $hidden = [];
}
