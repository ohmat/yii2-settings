<?php

namespace yii2mod\settings\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii2mod\editable\EditableAction;
use yii2mod\settings\models\enumerables\SettingStatus;
use yii2mod\settings\models\SettingModel;

/**
 * Class SettingController
 *
 * @package yii2mod\settings\controllers
 */
class DefaultController extends Controller
{
    /**
     * @var string path to index view file, which is used in admin panel
     */
    public $indexView = '@vendor/yii2mod/yii2-settings/views/default/index';

    /**
     * @var string path to create view file, which is used in admin panel
     */
    public $createView = '@vendor/yii2mod/yii2-settings/views/default/create';

    /**
     * @var string path to update view file, which is used in admin panel
     */
    public $updateView = '@vendor/yii2mod/yii2-settings/views/default/update';

    /**
     * @var string search class name for searching
     */
    public $searchClass = 'yii2mod\settings\models\search\SettingSearch';

    /**
     * @var string model class name for CRUD operations
     */
    public $modelClass = 'yii2mod\settings\models\SettingModel';

    /**
     * @var string path to index view file, which is used in admin panel
     */
    public $editView = '@vendor/yii2mod/yii2-settings/views/default/edit';

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'edit' => ['get', 'post'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Return a list of actions
     *
     * @return array
     */
    public function actions(): array
    {
        return [
            'edit-setting' => [
                'class' => EditableAction::class,
                'modelClass' => SettingModel::class,
                'forceCreate' => false,
            ],
        ];
    }

    /**
     * Lists all Settings.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->indexView, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Settings.
     *
     * @return mixed
     */
    public function actionEdit()
    {
        $searchModel = Yii::createObject($this->searchClass)->find()->where(['status'=>SettingStatus::ACTIVE])->all();

        $post = Yii::$app->request->post();
        if(!empty($post) && !empty($post["Settings"])){
            foreach ($post["Settings"] as $section=>$key){
                foreach ($key as $k=>$newSettings){
                    $s =$this->modelClass::find()->where(['section'=>$section,'key'=>$k])->one();
                    if(!empty($s->value) && $s->value!=$newSettings){
                        $s->value = trim($newSettings);
                        try{
                            $s->update();
                        }catch (Exception $e) {
                            Yii::$app->session->setFlash('error', $e->getMessage());
                        }
                    }
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.settings', 'Setting has been updated.'));
            $this->redirect('/settings/default/edit');
        }
        return $this->render($this->editView, [
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new Setting.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject($this->modelClass);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.settings', 'Setting has been created.'));

            return $this->redirect(['index']);
        } else {
            return $this->render($this->createView, [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Setting.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.settings', 'Setting has been updated.'));

            return $this->redirect(['index']);
        } else {
            return $this->render($this->updateView, [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Setting.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('yii2mod.settings', 'Setting has been deleted.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds a Setting model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return SettingModel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        $settingModelClass = $this->modelClass;

        if (($model = $settingModelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii2mod.settings', 'The requested page does not exist.'));
        }
    }

}
