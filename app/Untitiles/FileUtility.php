<?php

namespace App\Utilities;

class FileUtility {

    private static $filesDir = array(
        'documents',
    );

    public static function checkValidDirectory($dir)
    {
        if(!in_array($dir, self::$filesDir)) {
            throw new \Exception("Please provide valid directory");
        }

        return true;
    }

    /**
     * @param $fileName
     * @param string $directory
     * @param string $driver
     * @return string
     * @throws \Exception
     */
    public static function fileUrl($fileName, $directory = "files", $driver = "public")
    {
        if( !$fileName ) return "";

        self::checkValidDirectory($directory);
        $path = sprintf("%s%s/%s", env('APP_STORAGE_PATH'), $directory, $fileName);
        return app('filesystem')->disk($driver)->url($path);
    }

    /**
     * @param $file
     * @param $fileName
     * @param string $directory
     * @param string $driver
     * @return mixed
     * @throws \Exception
     */
    public static function uploadFile($file, $fileName, $directory = "files", $driver = "public")
    {
        self::checkValidDirectory($directory);

        $path = sprintf("%s%s/%s", env('APP_STORAGE_PATH'), $directory, $fileName);

        $uploaded = app('filesystem')->disk($driver)->put($path, $file);

        return $uploaded;
    }

    /**
     * @param $fileName
     * @param string $directory
     * @param string $driver
     * @return mixed
     * @throws \Exception
     */
    public static function getFile($fileName, $directory = "files", $driver = "public")
    {
        self::checkValidDirectory($directory);

        $path = sprintf("%s%s/%s", env('APP_STORAGE_PATH'), $directory, $fileName);

        $uploaded = app('filesystem')->disk($driver)->get($path);

        return $uploaded;
    }

    /**
     * @param $fileName
     * @param string $directory
     * @param string $driver
     * @return mixed
     * @throws \Exception
     */
    public static function deleteFile($fileName, $directory = "files",  $driver = "public")
    {
        self::checkValidDirectory($directory);

        return app('filesystem')
            ->disk($driver)
            ->delete(sprintf("%s%s/%s", env('APP_STORAGE_PATH'), $directory, $fileName));
    }
}
