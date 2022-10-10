<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const AVAILABLE_SPACE = 104857600;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'about_me',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function directories(): HasMany
    {
        return $this->hasMany(Directory::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Checks if the user has left disk space
     * @param int $size
     * @return bool
     */
    public function isFileFitOnDisk(int $size) : bool
    {
        $sum = $this->getAllUserFileDiskSpaceUsage();
        $diskSpaceLeft = self::AVAILABLE_SPACE - $sum;
        return $size < $diskSpaceLeft;
    }

    /**
     * Returns the size of all user files on the disk
     * @return int
     */
    public function getAllUserFileDiskSpaceUsage(): int
    {
        $sum = 0;

        foreach ($this->files as $file)
        {
            $sum += $file->getDiskSpaceUsage();
        }

        return $sum;
    }
}
