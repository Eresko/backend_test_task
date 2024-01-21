<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileElement extends Model
{
    protected $table = 'file_elements';

    protected $fillable = [
        'file_id',
        'line',
    ];


}