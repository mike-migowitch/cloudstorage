<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperFile
 */
class File extends Model
{
    use HasFactory;

    /**
     * Get the directory where the file is stored
     * @return HasOne
     */
    public function directory(): HasOne
    {
        return $this->hasOne(Directory::class);
    }
}
