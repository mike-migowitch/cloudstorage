<?php

namespace App\Interfaces;

interface DiskObjectInterface
{
    /**
     * Returns the disk space occupied by an object in bytes
     * @return int
     */
    public function getDiskSpaceUsage() : int;
}
