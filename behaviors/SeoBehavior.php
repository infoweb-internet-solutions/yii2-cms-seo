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

    private $_prop2;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
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
            echo __FILE__ . ' => ' . __LINE__; exit();
            /*
            return $this->render('create', [
                'model' => $this->owner->model,
                'templates' => $templates,
                'sliders' => $sliders,
            ]);
            */
        }

        $post = Yii::$app->request->post();

        // Save the translations
        foreach ($languages as $languageId => $languageName) {

            // Save the seo tag translations
            $data = $post['SeoLang'][$languageId];

            $seo                = $this->owner->seo;
            $seo->language      = $languageId;
            $seo->title         = (!empty($data[$this->titleAttribute])) ? $data[$this->titleAttribute] : $post['Lang'][$languageId][$this->titleAttribute];
            $seo->description   = $data['description'];
            $seo->keywords      = $data['keywords'];

            if (!$seo->saveTranslation()) {
                echo __FILE__ . ' => ' . __LINE__; exit();
            }
        }

        $transaction->commit();

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
            $seo->title         = (!empty($data[$this->titleAttribute])) ? $data[$this->titleAttribute] : $post['Lang'][$languageId][$this->titleAttribute];
            $seo->description   = $data['description'];
            $seo->keywords      = $data['keywords'];

            if (!$seo->saveTranslation()) {
                echo __FILE__ . ' => ' . __LINE__; exit();
            }
        }

        $transaction->commit();

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeo()
    {
        return $this->owner->hasOne(Seo::className(), ['entity_id' => 'id'])->where(['entity' => Page::className()]);
    }

    public function delete()
    {
        // Try to load and delete the attached 'Seo' entity
        if (!$this->seo->delete())
            throw new Exception(Yii::t('infoweb/seo', 'Error while deleting the attached seo tag'));
    }

}