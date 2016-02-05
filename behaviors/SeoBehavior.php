<?php

namespace infoweb\seo\behaviors;

use infoweb\pages\models\Page;
use yii;
use yii\base\Exception;
use infoweb\seo\models\Seo;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class SeoBehavior extends Behavior
{
    public $titleAttribute = 'title';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function afterInsert($event)
    {
        $languages = Yii::$app->params['languages'];

        // Wrap the everything in a database transaction
        $transaction = Yii::$app->db->beginTransaction();

        // Create the seo tag
        $seo = new Seo([
            'entity'    => $this->owner->className(),
            'entity_id' => $this->owner->id
        ]);

        if (!$seo->save()) {
            return false;
        }

        $post = Yii::$app->request->post();

        foreach ($languages as $languageId => $languageName) {

            // Save the seo tag translations
            $data = $post['SeoLang'][$languageId];

            $seo                = $this->owner->seo;
            $seo->language      = $languageId;
            $seo->title         = (!empty($post['title'])) ? $data['title'] : $post['Lang'][$languageId][$this->titleAttribute];
            $seo->description   = $data['description'];
            $seo->keywords      = $data['keywords'];

            if (!$seo->saveTranslation()) {
                return false;
            }
        }

        $transaction->commit();

        return true;
    }

    public function afterUpdate($event)
    {
        $languages = Yii::$app->params['languages'];

        // Wrap the everything in a database transaction
        $transaction = Yii::$app->db->beginTransaction();

        $post = Yii::$app->request->post();

        // Save the translations
        foreach ($languages as $languageId => $languageName) {

            // Save the seo tag translations
            $data = $post['SeoLang'][$languageId];

            $seo                = $this->owner->seo;
            $seo->language      = $languageId;
            $seo->title         = (!empty($post['title'])) ? $data['title'] : $post['Lang'][$languageId][$this->titleAttribute];
            $seo->description   = $data['description'];
            $seo->keywords      = $data['keywords'];

            if (!$seo->saveTranslation()) {
                return false;
            }
        }

        $transaction->commit();

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeo()
    {
        return $this->owner->hasOne(Seo::className(), ['entity_id' => 'id'])->where(['entity' => $this->owner->className()]);
    }

    public function beforeDelete()
    {
        // Try to load and delete the attached 'Seo' entity
        return $this->seo->delete();
    }

    /**
     * Returns an array of the non-empty seo tags that are attached to the page.
     *
     * @return  array
     */
    public function getSeoTags()
    {
        return array_filter($this->owner->seo->getTranslation((($this->owner->language == null) ? Yii::$app->language : $this->owner->language))->attributes);
    }

}