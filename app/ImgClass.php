<?php


class Img {

    public const DIR = [
        'categories' => '/assets/imgs/uploads/categories/',
        'products' => '/assets/imgs/uploads/products/',
    ];

    // public const SUB_DIR = [
    //     'products_avatar' => '/avatar',
    //     'products_other_imgs' => '/other'
    // ];

    public static function uploadImg($img, $dir_name, $folder_name){
        $dir = $_SERVER['DOCUMENT_ROOT'].self::DIR[$dir_name].$folder_name.'/';
        $file_type = pathinfo($img['name'], PATHINFO_EXTENSION);
        $file_name = substr(md5(microtime() . rand(0, 1000)), 0, 15).'.'.$file_type;
 
        if(!file_exists($dir)){
             mkdir($dir, 0777, true);
        }
        move_uploaded_file($img['tmp_name'], $dir.'/'.$file_name);
        $path = $folder_name.'/'.$file_name;
        return $path;
    }

    public static function getImages($array){
        foreach($array as $key => $imgs){
            foreach ($imgs as $key2 => $img){
              $imgs_arr[$key2][$key] = $img;
            }
        }
        return $imgs_arr;
    }

    public static function deleteDir($dir_name, $folder_name){
        $dir = $_SERVER['DOCUMENT_ROOT'].self::DIR[$dir_name].$folder_name.'/';
        if(file_exists($dir)){
            $files = array_diff(scandir($dir), ['.','..']);
            foreach ($files as $file) {
                (is_dir($dir.'/'.$file)) ? self::deleteDir($dir_name, $folder_name, $file) : unlink($dir.$file);
            }
            return rmdir($dir);
        }
    }

    public static function renameDir($dir_name, $old, $new){
        $dir = $_SERVER['DOCUMENT_ROOT'].self::DIR[$dir_name];
        rename($dir.$old.'/', $dir.$new.'/');
    }

    public static function deleteImg($dir_name, $folder_name, $img){
        $dir = $_SERVER['DOCUMENT_ROOT'].self::DIR[$dir_name].$folder_name.'/'.$img;
        if(file_exists($dir)){
            $delete = unlink($dir);
            return $delete;
        }else{
            return false;
        }
    }
}