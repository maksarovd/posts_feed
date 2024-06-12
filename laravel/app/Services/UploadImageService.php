<?php

namespace App\Services;

use App\Models\File;
use Exception;
use GdImage;


class UploadImageService
{

    /**
     * Upload
     *
     *
     * @param $extension
     * @param $name
     * @access public static
     * @throws Exception
     */
    public static function upload($extension, $name)
    {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $name)) {

            if ($image = self::createImage($extension, $name)) {
                self::writeImage(
                    $extension,
                    $name,
                    self::resizeImage($image,File::MEDIA_FILE_WIDTH,File::MEDIA_FILE_HEIGHT)
                );
            }
        } else {
            throw new Exception(__('failed Upload'));
        }
    }


    /**
     * Create Image
     *
     *
     * @param $extension
     * @param $name
     * @access public static
     * @return false|GdImage
     */
    public static function createImage($extension, $name): GdImage|bool
    {
        if($extension === File::GIF_FILE_EXTENSION){
            return imagecreatefromgif($name);
        }
        if($extension === File::JPEG_FILE_EXTENSION || $extension === File::JPG_FILE_EXTENSION){
            return imagecreatefromjpeg($name);
        }
        if($extension === File::PNG_FILE_EXTENSION){
            return imagecreatefrompng($name);
        }
        return false;
    }


    /**
     * Write Image
     *
     *
     * @param $extension
     * @param $name
     * @param $resizedImage
     * @access public static
     * @throws Exception
     */
    public static function writeImage($extension, $name, $resizedImage)
    {
        if(!is_dir(storage_path('app/public/uploads'))){
            mkdir(storage_path('app/public/uploads'));
        }

        if($extension === File::GIF_FILE_EXTENSION){
            if (!imagegif ($resizedImage, storage_path('app/public/uploads/'). $name )) {
                throw new Exception(__('failed to save resized image'));
            }
        }
        if($extension === File::JPEG_FILE_EXTENSION || $extension === File::JPG_FILE_EXTENSION){
            if (!imagejpeg ($resizedImage, storage_path('app/public/uploads/'). $name )) {
                throw new Exception(__('failed to save resized image'));
            }
        }
        if($extension === File::PNG_FILE_EXTENSION){
            if (!imagepng ($resizedImage, storage_path('app/public/uploads/'). $name )) {
                throw new Exception(__('failed to save resized image'));
            }
        }
    }


    /**
     * Resize Image
     *
     *
     * @param $image
     * @param $w
     * @param $h
     * @access public static
     * @return false|GdImage
     */
    public static function resizeImage($image, $w, $h): GdImage|bool
    {
        $oldw = imagesx($image);
        $oldh = imagesy($image);
        $temp = imagecreatetruecolor($w, $h);
        imagecopyresampled($temp, $image, 0, 0, 0, 0, $w, $h, $oldw, $oldh);
        return $temp;
    }
}
