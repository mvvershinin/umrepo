<?php

namespace app\api\modules\v1;

/**
 * api module definition class
 */
use \yii\base\Module;

class Api extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
