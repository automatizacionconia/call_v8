<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class ImagenService
{
    public function optimizarImagen($photo, $encode, $aspectRatio = false)
    {
        $image = Image::make($photo);

        if ($aspectRatio) {
            $image->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        return $image->encode('jpg', $encode);
    }
}
