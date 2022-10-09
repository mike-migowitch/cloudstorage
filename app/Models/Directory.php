<?php

namespace App\Models;

use App\Interfaces\DiskObjectInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperDirectory
 */
class Directory extends Model implements DiskObjectInterface
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getDiskSpaceUsage() : int
    {
        // TODO логика подсчета
        return 123;
    }

    /**
     * Get all files from a directory
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
