<?php

namespace infoweb\seo;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'infoweb\seo\controllers';

    /**
     * Allow content duplication with the "duplicateable" plugin
     * @var boolean
     */
    public $allowContentDuplication = true;

    public function init()
    {
        parent::init();
    }
}
