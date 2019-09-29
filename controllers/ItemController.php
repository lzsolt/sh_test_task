<?php

namespace app\controllers;

use app\models\Queue;
use Yii;
use app\models\Item;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actionStat(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = [];

        foreach (Item::getItemsStat() as $yearMonth) {
            $result[] = [
                'year' => $yearMonth->year,
                'month' => $yearMonth->month,
                'count' => $yearMonth->count
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $post = Yii::$app->request->post();
        } catch (Exception $e) {
            return [$e->getMessage()];
        }

        $model = new Queue();
        $model->setAttributes([
            'message' => json_encode($post)
        ]);

        if ($model->save()) {
            return ['event_id' => $model->getPrimaryKey()];
        } else {
            return ['error' => "Data can't save"];
        }
    }

    /**
     * @return array
     */
    public function actionEventStatus(): array
    {
        if ($model = Queue::findOne(['id' => Yii::$app->request->get('eventId')])) {
            $result = [
                'event_id' => $model->getAttribute('id'),
                'try_processing_num' => $model->getAttribute('fail_count'),
                'message' => $model->getAttribute('fail_count') >= $model::_TRY_NUM ? 'Too much attempts.' : 'Subsequent processing.'
            ];
        } else {
            $result = ['message' => 'Event not exist. Maybe it was processed earlier.'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
