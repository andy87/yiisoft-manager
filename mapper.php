<?php

use \andy87\yii2\migrate\Manager;

class_alias(Manager::class, 'andy87\yii2\migrate');


$filename   = 'tpl/console_components_Manager.php';
$filePath   = Yii::getAlias('@console/components/Manager2.php');

if ( !file_exists($filePath) )
{
    $dir = Yii::getAlias('@console/components');

    if ( !is_dir($dir) )
    {
        mkdir($dir);
    }

    copy( $filename, $filePath );
}