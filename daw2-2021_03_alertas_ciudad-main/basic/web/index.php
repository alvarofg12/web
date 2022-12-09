<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Logs;
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';


(new yii\web\Application($config))->run();

//var_dump(Yii::$app->log->logger->messages);

foreach (Yii::$app->log->logger->messages as $valor){
    $model = new Logs();

    /*
    [
        [0] => message (mixed, can be a string or some complex data, such as an exception object)
        [1] => level (integer)
        [2] => category (string)
        [3] => timestamp (float, obtained by microtime(true))
        [4] => traces (array, debug backtrace, contains the application code call stacks)
        [5] => memory usage in bytes (int, obtained by memory_get_usage()), available since version 2.0.11.
    ]*/
    
    if($valor[1]== 4){$model->clase_log_id= "I";}
    if($valor[1]== 8){$model->clase_log_id= "S";}
    if($valor[1]== 12){$model->clase_log_id= "E";}
    if($valor[1]== 16){$model->clase_log_id= "I";}
    if($valor[1]== 20){$model->clase_log_id= "D";}

    $model->crea_fecha=date("Y-m-d H:i:s");
    $model->modulo=$valor[2];
    $model->texto=$valor[0];

    $model->insert();



}