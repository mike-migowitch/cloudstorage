<?php

namespace App\Models;

use App\Interfaces\DiskObjectInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
