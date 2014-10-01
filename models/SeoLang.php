<?php

namespace infoweb\seo\models;

use Yii;

/**
 * This is the model class for table "seo_lang".
 *
 * @property string $seo_id
 * @property string $language
 * @property string $title
 * @property string $description
 */
class SeoLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['seo_id', 'language', 'title', 'description'], 'required'],
            //[['seo_id'], 'integer'],
            //[['language'], 'string', 'max' => 5],
            //[['title', 'description'], 'string', 'max' => 255],
            [['seo_id', 'language'], 'unique', 'targetAttribute' => ['seo_id', 'language'], 'message' => 'The combination of Seo ID and Language has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'seo_id' => Yii::t('app', 'Seo ID'),
            'language' => Yii::t('app', 'Language'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::className(), ['id' => 'seo_id']);
    }
}