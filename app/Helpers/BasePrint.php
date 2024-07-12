<?php

namespace App\Helpers;

class BasePrint {

    public static function defaultNative()
    {
        $tmpdir = sys_get_temp_dir();  
        $file =  tempnam($tmpdir, 'ctk'); 
        $handle = fopen($file, 'w');
        $condensed = Chr(27) . Chr(33) . Chr(4);
        $bold1 = Chr(27) . Chr(69);
        $bold0 = Chr(27) . Chr(70);
        $initialized = chr(27).chr(64);
        $condensed1 = chr(15);
        $condensed0 = chr(18);
        $Data  = $initialized;
        $Data .= $condensed1;
        $Data .= "==========================\n";
        $Data .= "|     ".$bold1."HANNY JAYA".$bold0."      |\n";
        $Data .= "==========================\n";
        $Data .= "Hanny Jaya is here\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "--------------------------\n";
        fwrite($handle, $Data);
        fclose($handle);
        copy($file, "//localhost/xprinter");  
        unlink($file);
    }
}