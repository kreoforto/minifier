<?php

require_once("YUICompressor.php");


class PHPMinifier {
    
    const YUI_COMPRESSOR = "/Applications/XAMPP/htdocs/minifier/yuicompressor-2.4.2.jar";
    const YUI_TEMP_DIR   = "/Applications/XAMPP/htdocs/minifier/temp/";
    
    private static function Extract($tmp_file, $name) {
        
        $data = array();
        $match = array();
        
        if(is_uploaded_file($tmp_file) && preg_match("/\.(js|JS|css|CSS)$/", trim($name), $match)) {
            $data[0] = file_get_contents($tmp_file);
            $data[1] = strtoupper($match[1]);
        }
        else {
            throw new InvalidArgumentException;
        }        
        
        return $data;
    }
    
    public static function Minify($tmp_files, $names) {
        
        $tmp_files = (array)$tmp_files; $names = (array)$names;
        $tmp_files = array_filter($tmp_files, create_function('$val', 'return !empty($val);'));
        $names     = array_filter($names, create_function('$val', 'return !empty($val);'));
        if(count($tmp_files) != count($names)) throw new InvalidArgumentException;
        
        $func = array( "JS" => "minifyJs", "CSS" => "minifyCss" );
        Minify_YUICompressor::$jarFile = self::YUI_COMPRESSOR;
        Minify_YUICompressor::$tempDir = self::YUI_TEMP_DIR;
        
        $content = "";
        if(count($tmp_files) > 0) {
            $files = array_combine($names, $tmp_files);
            foreach( $files as $n => $f ) {
                
                $data = self::Extract($f, $n);        
                if($data[1] === "JS" || $data[1] === "CSS") {
                    $content .= Minify_YUICompressor::$func[$data[1]]( $data[0] );
                }        
            }
        }
        
        $temp = tmpfile();
        fwrite($temp, $content);
        fseek($temp, 0);
        
        return $temp;
    }
}

?>