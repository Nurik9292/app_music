<?php

namespace App\Services\Admin;

class HelperService
{
    public $pathImageForServer = "/home/nury/nfs/storage2/images/";
    public $pathTrackForServer = "/home/nury/nfs/storage2/";
    public $pathImageForDb = "/home/nury/nfs/storage2/images/";

    // public $pathImageForDb = "https://storage2.ma.st.com.tm/images/";
    // public $pathImageForServer = "/nfs/storage2/images/";
    // public $pathTrackForServer = "/nfs/storage2/";





    public function delete($path)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), ['.', '..']);

            foreach ($files as $file) {
                $this->delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }
}
