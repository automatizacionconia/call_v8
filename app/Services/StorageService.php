<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    protected $filesystemDriver;

    public function __construct()
    {
        $this->filesystemDriver = env('FILESYSTEM_DRIVER');
    }

    public function setDisk($disk)
    {
        $this->filesystemDriver = $disk;
    }

    public function store($ubicacion, $file, $filename)
    {
        return Storage::disk($this->filesystemDriver)->putFileAs($ubicacion, $file, $filename);
    }

    public function show($key, $name)
    {
        return Storage::disk($this->filesystemDriver)->response($key, $name);
    }

    public function destroy($key)
    {
        return Storage::disk($this->filesystemDriver)->delete($key);
    }

    public function exists($key)
    {
        return Storage::disk($this->filesystemDriver)->exists($key);
    }

    public function url($key)
    {
        return Storage::disk($this->filesystemDriver)->url($key);
    }
}
