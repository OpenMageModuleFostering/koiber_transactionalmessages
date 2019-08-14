<?php

//function __autoload($classname) {
    $paths = array(
        "", 
        'Message/',
        'Form/'
    );
    
    foreach ($paths as $path) {
		foreach (glob(__DIR__ . '/' . $path . '*.php') as $file) {
			include_once $file;
		}
        /*$file = sprintf('%s/%s%s.php', dirname(__FILE__), $path, $classname);
        if(file_exists($file)) {
            include_once $file;
            return;
        }*/
    }
//}