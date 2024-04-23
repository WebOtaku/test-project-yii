<?php

namespace app\controllers;

use app\models\IpGeo;
use app\models\IpInfo;
use app\models\IpInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * IpInfoController implements the CRUD actions for IpInfo model.
 */
class IpInfoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all IpInfo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new IpInfoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $dataProvider->totalCount,
        ]);

        $dataProvider->setPagination($pagination);

        return $this->render('index.twig', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IpInfo model.
     * @param string $ip Ip
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ip)
    {
        return $this->render('view', [
            'model' => $this->findModel($ip),
        ]);
    }

    /**
     * Creates a new IpInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new IpInfo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $ch = curl_init('http://www.geoplugin.net/json.gp?ip=' . $model->ip);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response);

                $ipGeo = new IpGeo();

                if ($ipGeo->load((array) $response, '') && $ipGeo->validate()) {
                    $ipInfo = array_merge($model->toArray(), $ipGeo->toArray());
                    $model->load($ipInfo, '');
                }

                $model->save();
                return $this->redirect(['view', 'ip' => $model->ip]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create.twig', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing IpInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $ip Ip
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ip)
    {
        $model = $this->findModel($ip);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ip' => $model->ip]);
        }

        return $this->render('update.twig', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing IpInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $ip Ip
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ip)
    {
        $this->findModel($ip)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the IpInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ip Ip
     * @return IpInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ip)
    {
        if (($model = IpInfo::findOne(['ip' => $ip])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
