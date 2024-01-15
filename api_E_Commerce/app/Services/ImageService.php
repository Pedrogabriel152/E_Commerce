<?php

namespace App\Services;

class ImageService 
{
    public static function saveImage(array $args, string $folder, int $id, string $atualImage = null) {
        $updateImage = $atualImage;
        if(array_key_exists('image', $args)){
            $image = $args['image'];
            $extension = $image->extension();
            $imageName = md5($image->getClientOriginalName() . strtotime("now")).".".$extension;
            $image->move(public_path("img/$folder/$id"), $imageName);
            $updateImage = "img/$folder/$id/$imageName";
        }

        return $updateImage;
    }
}