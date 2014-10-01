<?php

namespace infoweb\seo\models;

use Yii;
use dosamigos\translateable\TranslateableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use infoweb\pages\models\Page;

/**
 * This is the model class for table "seo".
 *
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $created_at
 * @property string $updated_at
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

    public function behaviors()
    {
        return [
            'trans' => [ // name it the way you want
                'class' => TranslateableBehavior::className(),
                // in case you named your relation differently, you can setup its relation name attribute
                // 'relation' => 'translations',
                // in case you named the language column differently on your translation schema
                // 'languageField' => 'language',
                'translationAttributes' => [
                    'title', 'description'
                ]
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entity_id'], 'required'],
            [['entity'], 'string'],
            //[['created_at', 'updated_at'], 'integer'],
            [['entity', 'entity_id'], 'unique', 'targetAttribute' => ['entity', 'entity_id'], 'message' => 'The combination of Entity and Entity ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'entity' => Yii::t('app', 'Entity'),
            'entity_id' => Yii::t('app', 'Entity ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(SeoLang::className(), ['seo_id' => 'id']);
    }

    public function getEntityTitle()
    {

        if ($this->entity == 'page') {

            $page = Page::findOne($this->entity_id);
            return $page->title;
        }

        return '';
    }
}