<?php 

if (!empty($errors)) {
    $errorArray = array();

    foreach ($errors as $error) {
        echo  trim(esc($error));
    }

    
}