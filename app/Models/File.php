<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    
    protected $fillable = ['name', 'url', 'type', 'mimetype', 'rand_dir', 'author_id'];
}
