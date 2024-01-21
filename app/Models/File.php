<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'name'
    ];

    public function fileElement(): HasMany
    {
        return $this->hasMany(FileElement::class, 'file_id', 'id');
    }

}