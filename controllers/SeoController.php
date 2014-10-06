<?php

namespace infoweb\seo\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\base\Model;
use infoweb\seo\models\Seo;
use infoweb\seo\models\SeoLang;
use infoweb\seo\models\SeoSearch;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Seo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Seo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $languages = Yii::$app->params['languages'];
        
        // Load the model, default to 'user-defined' type
        $model = new Seo(['entity' => 'page']);
        
        // Load all the translations
        $model->loadTranslations(array_keys($languages));
        
        // Load the entities
        $entities = [];
        $entities['pages'] = (new Query())
                                ->select('page.id, page_lang.name')
                                ->from(['page' => 'pages'])
                                ->innerJoin(['page_lang' => 'pages_lang'], "page.id = page_lang.page_id AND page_lang.language = '".Yii::$app->language."'")
                                ->orderBy(['page_lang.name' => SORT_ASC])
                                ->all();

        if (Yii::$app->request->getIsPost()) {
            
            $post = Yii::$app->request->post();
            
            // Ajax request, validate the models
            if (Yii::$app->request->isAjax) {
                               
                // Populate the model with the POST data
                $model->load($post);
                
                // Create an array of translation models
                $translationModels = [];
                
                foreach ($languages as $languageId => $languageName) {
                    $translationModels[$languageId] = new SeoLang(['language' => $languageId]);
                }
                
                // Populate the translation models
                Model::loadMultiple($translationModels, $post);

                // Validate the model and translation models
                $response = array_merge(ActiveForm::validate($model), ActiveForm::validateMultiple($translationModels));
                
                // Return validation in JSON format
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $response;
            
            // Normal request, save models
            } else {
                // Wrap the everything in a database transaction
                $transaction = Yii::$app->db->beginTransaction();                
                
                // Save the main model
                if (!$model->load($post) || !$model->save()) {
                    return $this->render('create', [
                        'model' => $model,
                        'entities' => $entities
                    ]);
                } 
                
                // Save the translations
                foreach ($languages as $languageId => $languageName) {
                    
                    $data = $post['SeoLang'][$languageId];
                    
                    // Set the translation language and attributes                    
                    $model->language    = $languageId;
                    $model->title       = $data['title'];
                    $model->description = $data['description'];
                    $model->keywords    = $data['keywords'];
                    
                    if (!$model->saveTranslation()) {
                        return $this->render('create', [
                            'model' => $model,
                            'entities' => $entities
                        ]);    
                    }                      
                }
                
                $transaction->commit();
                
                // Switch back to the main language
                $model->language = Yii::$app->language;
                
                // Set flash message
                Yii::$app->getSession()->setFlash('seo', Yii::t('app', '{entity} "{item}" has been created', ['entity' => $model->entityTypeName, 'item' => $model->entityModel->name]));
              
                // Take appropriate action based on the pushed button
                if (isset($post['close'])) {
                    return $this->redirect(['index']);
                } elseif (isset($post['new'])) {
                    return $this->redirect(['create']);
                } else {
                    return $this->redirect(['update', 'id' => $model->id]);
                }    
            }    
        }
        
        return $this->render('create', [
            'model' => $model,
            'entities' => $entities
        ]);
    }

    /**
     * Updates an existing Seo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $languages = Yii::$app->params['languages'];
        $model = $this->findModel($id);

        // Load all the translations
        $model->loadTranslations(array_keys($languages));
        
        // Load the entities
        $entities = [];
        $entities['pages'] = (new Query())
                                ->select('page.id, page_lang.name')
                                ->from(['page' => 'pages'])
                                ->innerJoin(['page_lang' => 'pages_lang'], "page.id = page_lang.page_id AND page_lang.language = '".Yii::$app->language."'")
                                ->orderBy(['page_lang.name' => SORT_ASC])
                                ->all();

        if (Yii::$app->request->getIsPost()) {
            
            $post = Yii::$app->request->post();
            
            // Ajax request, validate the models
            if (Yii::$app->request->isAjax) {
                               
                // Populate the model with the POST data
                $model->load($post);
                
                // Create an array of translation models
                $translationModels = [];
                
                foreach ($languages as $languageId => $languageName) {
                    $translationModels[$languageId] = new SeoLang(['language' => $languageId]);
                }
                
                // Populate the translation models
                Model::loadMultiple($translationModels, $post);

                // Validate the model and translation models
                $response = array_merge(ActiveForm::validate($model), ActiveForm::validateMultiple($translationModels));
                
                // Return validation in JSON format
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $response;
            
            // Normal request, save models
            } else {
                // Wrap the everything in a database transaction
                $transaction = Yii::$app->db->beginTransaction();                
                
                // Save the main model
                if (!$model->load($post) || !$model->save()) {
                    return $this->render('update', [
                        'model' => $model,
                        'entities' => $entities
                    ]);
                } 
                
                // Save the translations
                foreach ($languages as $languageId => $languageName) {
                    
                    $data = $post['SeoLang'][$languageId];
                    
                    // Set the translation language and attributes                    
                    $model->language    = $languageId;
                    $model->title       = $data['title'];
                    $model->description = $data['description'];
                    $model->keywords    = $data['keywords'];
                    
                    if (!$model->saveTranslation()) {
                        return $this->render('update', [
                            'model' => $model,
                            'entities' => $entities
                        ]);    
                    }                      
                }
                
                $transaction->commit();
                
                // Switch back to the main language
                $model->language = Yii::$app->language;
                
                // Set flash message
                Yii::$app->getSession()->setFlash('seo', Yii::t('app', '{entity} "{item}" has been updated', ['entity' => $model->entityTypeName, 'item' => $model->entityModel->name]));
              
                // Take appropriate action based on the pushed button
                if (isset($post['close'])) {
                    return $this->redirect(['index']);
                } elseif (isset($post['new'])) {
                    return $this->redirect(['create']);
                } else {
                    return $this->redirect(['update', 'id' => $model->id]);
                }    
            }    
        }
        
        return $this->render('update', [
            'model' => $model,
            'entities' => $entities
        ]);
    }

    /**
     * Deletes an existing Seo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Seo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Seo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
