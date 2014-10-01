<?php

namespace infoweb\seo\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $image;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['image'], 'image', 'skipOnEmpty' => false, /*'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',*/],
        ];
    }
}