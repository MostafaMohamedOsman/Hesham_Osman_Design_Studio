<?php

namespace App\Http\Traits;
trait media
{
    public function uploadPhoto($img,$dir): string
    {
        $imgName = uniqid() . '.' . $img->extension();
        $img->move(public_path("/dist/img/$dir/"), $imgName);
        return $imgName;
    }
    public function deletePhoto($imgPath): bool
    {
        if (file_exists($imgPath)) {
            unlink($imgPath);
            return true;
        }
        return false;
    }
}
