<?php

namespace infoweb\seo\controllers;

use Yii;
use infoweb\seo\models\Seo;
use infoweb\seo\models\SeoLang;
use infoweb\seo\models\SeoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

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
        $model = new Seo();

        $pages = [];

        // @todo Rewrite Query
        $q = new Query();
        $results =  $q->select('`p`.`id`, `pl`.`title`')
            ->from('`pages` AS `p`')
            ->innerjoin('`pages_lang` AS `pl`', '`p`.`id` = `pl`.`page_id`')
            ->where("`pl`.`language` = '" . Yii::$app->language . "'")
            ->orderBy('`pl`.`title`')
            ->all();

        foreach ($results as $result)
        {
            $pages[$result['id']] = $result['title'];
        }

        if (Yii::$app->request->getIsPost()) {

            $post = Yii::$app->request->post();

            if (!$model->load($post)) {
                echo 'Model not loaded';
                exit();
            }

            if (!$model->save()) {
                echo 'Model not saved';
                exit();
            }

            foreach (Yii::$app->params['languages'] as $k => $v) {

                $modelLang = $model->getTranslation($k);

                // nl-BE already exists after saving the model
                if (!isset($modelLang)) {
                    $modelLang = new SeoLang;
                }

                $modelLang->seo_id = $model->id;
                //$modelLang->load($post[$k]);
                $modelLang->title = $post[$k]['SeoLang']['title'];
                $modelLang->description = $post[$k]['SeoLang']['description'];
                $modelLang->language = $post[$k]['SeoLang']['language'];

                if (!$modelLang->save()) {
                    echo 'Model lang not saved';
                    exit();
                }
            }

            if (isset($post['close'])) {
                return $this->redirect(['index']);
            } elseif (isset($post['new'])) {
                return $this->redirect(['create']);
            } else {
                return $this->redirect(['update', 'id' => $model->id]);
            }

        } else {

            return $this->render('create', [
                'model' => $model,
                'entities' => ['page' => 'page'],
                'pages' => $pages,
            ]);
        }
    }

    /**
     * Updates an existing Seo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $pages = [];

        // @todo Rewrite Query
        $q = new Query();
        $results =  $q->select('`p`.`id`, `pl`.`title`')
            ->from('`pages` AS `p`')
            ->innerjoin('`pages_lang` AS `pl`', '`p`.`id` = `pl`.`page_id`')
            ->where("`pl`.`language` = '" . Yii::$app->language . "'")
            ->orderBy('`pl`.`title`')
            ->all();

        foreach ($results as $result)
        {
            $pages[$result['id']] = $result['title'];
        }

        if (Yii::$app->request->getIsPost()) {

            $post = Yii::$app->request->post();
            if (!$model->load($post)) {
                return 'Model not loaded';
                exit();
            }

            if (!$model->save()) {
                return 'Model not saved';
                exit();
            }

            foreach (Yii::$app->params['languages'] as $k => $v) {
                $modelLang = $model->getTranslation($k);
                $modelLang->seo_id = $model->id;
                //$modelLang->load($post[$k]);
                $modelLang->title = $post[$k]['SeoLang']['title'];
                $modelLang->description = $post[$k]['SeoLang']['description'];

                if (!$modelLang->save()) {
                    echo 'Model lang not saved';
                    exit();
                }
            }

            if (isset($post['close'])) {
                return $this->redirect(['index']);
            } elseif (isset($post['new'])) {
                return $this->redirect(['create']);
            } else {
                return $this->redirect(['update', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'entities' => ['page' => 'page'],
                'pages' => $pages,
            ]);
        }
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
