<?php

namespace App\Models;

use ZipArchive;

class Download extends Model
{
    public static function download($username)
    {
        $filename = '../../storage/wc.exe';
        if (file_exists($filename)) 
        {            
            $zip = new ZipArchive();        
            $tmp_file = tempnam('../../storage/tmp','DOWN');
            $zip->open($tmp_file, ZipArchive::CREATE);
            $zip->addFromString($username.".exe", file_get_contents($filename));
            $zip->setEncryptionName($username.".exe", ZipArchive::EM_AES_256, 'wc');
            $zip->setArchiveComment('Contraseña para extraer: wc');
            $zip->close();
            header("Content-disposition: attachment; filename={$username}.zip");
            header("Content-type: application/zip");
            readfile($tmp_file);
            unlink($tmp_file);
            return true;
        } 
        else
        {
            return false;
        } 
    }
}
