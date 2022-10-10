<?php

namespace App\Models;

use App\Interfaces\DiskObjectInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperDirectory
 */
class Directory extends Model implements DiskObjectInterface
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function getDiskSpaceUsage() : int
    {
        $sum = 0;

        foreach ($this->files as $file) {
            $sum += $file->getDiskSpaceUsage();
        }

        return $sum;
    }

    /**
     * Get all files from a directory
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
