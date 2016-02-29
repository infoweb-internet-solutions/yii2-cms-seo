<?php

namespace infoweb\seo\controllers;

use Yii;
use yii\web\Controller;
use infoweb\settings\models\Setting;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
{
    /**
     * Lists all Seo models.
     * @return mixed
     */
    public function actionIndex()
    {

        $languages = Yii::$app->params['languages'];
        $tags = [
            'title' => Setting::findOne(['key' => 'seo/meta/title']),
            'description' => Setting::findOne(['key' => 'seo/meta/description']),
            'keywords' => Setting::findOne(['key' => 'seo/meta/keywords'])
        ];

        if (Yii::$app->request->getIsPost()) {

            $post = Yii::$app->request->post();

            try {
                // Load the models
                $title = Setting::findOne(['key' => 'seo/meta/title']);
                $description = Setting::findOne(['key' => 'seo/meta/description']);
                $keywords = Setting::findOne(['key' => 'seo/meta/keywords']);

                // Wrap the everything in a database transaction
                $transaction = Yii::$app->db->beginTransaction();

                // Update the values
                foreach ($languages as $languageId => $languageName) {
                    // Update 'seo/meta/title'
                    $title->translate($languageId)->value  = $post['title'][$languageId];

                    // Update 'seo/meta/description'
                    $description->translate($languageId)->value  = $post['description'][$languageId];

                    // Update 'seo/meta/keywords'
                    $keywords->translate($languageId)->value  = $post['keywords'][$languageId];
                }

                if (!$title->save()) {
                    return $this->render('settings', ['tags' => $tags]);
                }

                if (!$description->save()) {
                    return $this->render('settings', ['tags' => $tags]);
                }

                if (!$keywords->save()) {
                    return $this->render('settings', ['tags' => $tags]);
                }

                $transaction->commit();

                // Set flash message
                Yii::$app->getSession()->setFlash('seo', Yii::t('app', 'The settings have been updated'));

                return $this->redirect(['index']);

            } catch (\Exception $e) {
                return $this->render('settings', ['tags' => $tags, 'errors' => $e->getMessage()]);
            }
        }

        return $this->render('settings', ['tags' => $tags]);
    }
}
