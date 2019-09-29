<?php

namespace app\commands;


use app\helper\item\ItemHelper;
use app\models\Item;
use app\models\Queue;
use yii\base\ErrorException;
use yii\console\Controller;

/**
 * Class WorkerController
 * @package app\commands
 */
class WorkerController extends Controller
{
    /**
     * @param int $loopTime
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionIndex($loopTime = 1)
    {
        loop:
        /** @var Queue $queue */
        $queue = Queue::getNextQueue();

        if (!$queue) {
            echo 'Queue is empty'.PHP_EOL;
        } else {
            $itemHelper = new ItemHelper();
            try {
                if ($this->randFail()) {
                    throw new ErrorException();
                }

                $modelArray = $itemHelper->generateModelArray($queue->getAttribute('message'));

                $item = new Item();
                $item->setAttributes($modelArray);

                if ($item->save()) {
                    $deletedQueueId = $queue->deleteWithReturnId();
                    echo sprintf('Queue message worked successfully [QueueID: %s]', $deletedQueueId) . PHP_EOL;
                } else {
                    throw new ErrorException('Failed save');
                }
            } catch (ErrorException $e) {
                echo sprintf('Queue message failed [QueueID: %s]', $queue->getAttribute('id')) . PHP_EOL;
                $queue->increaseFailCounter();
            }
        }

        usleep($loopTime * 1000000);

        goto loop;
    }

    /**
     * @return bool
     */
    private function randFail(): bool
    {
        if (rand(1, 3) === 3) {
            return false;
        } else {
            return true;
        }
    }
}
