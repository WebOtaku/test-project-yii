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
 * IpInfoController реализует CRUD для модели IpInfo
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
     * Список всех моделей IpInfo.
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
     * Отображает единичный экземпляр модели IpInfo.
     * @param string $ip IP-адрес
     * @return string
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    public function actionView($ip)
    {
        return $this->render('view.twig', [
            'model' => $this->findModel($ip),
        ]);
    }

    /**
     * Создает новый экземпляр модели IpInfo
     * Если экземпляр был успешно создан, то будет выполнено перенаправление на страницу просмотра.
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
     * Обновляет существующую модель IpInfo.
     * Если обновление успешно, то будет выполнено перенаправление на страницу просмотра.
     * @param string $ip IP-адрес
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    public function actionUpdate($ip)
    {
        $model = $this->findModel($ip);

        $model->scenario = IpInfo::SCENARIO_UPDATE;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ip' => $model->ip]);
        }

        return $this->render('update.twig', [
            'model' => $model,
        ]);
    }

    /**
     * Удаляет существующую модель IpInfo.
     * Если удаление успешно, то будет выполнено перенаправление на страницу 'index'.
     * @param string $ip IP-адрес
     * @return \yii\web\Response
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    public function actionDelete($ip)
    {
        $this->findModel($ip)->delete();

        return $this->redirect(['/']);
    }

    /**
     * Находит модель IpInfo на основе значения ее первичного ключа.
     * Если модель не найдена, будет выброшено исключение HTTP 404.
     * @param string $ip IP-адрес
     * @return IpInfo загружаемая модель
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($ip)
    {
        if (($model = IpInfo::findOne(['ip' => $ip])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
