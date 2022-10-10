<?php

namespace App\Models;

use App\Interfaces\DiskObjectInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperFile
 */
class File extends Model implements DiskObjectInterface
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'directory_id',
        'filename',
        'disk_space'
    ];

    /**
     * Get the directory where the file is stored
     * @return HasOne
     */
    public function directory(): HasOne
    {
        return $this->hasOne(Directory::class);
    }

    /**
     * Get owner
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getDiskSpaceUsage() : int
    {
        return $this->attributes['disk_space'];
    }
}
