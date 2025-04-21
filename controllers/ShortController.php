<?php

namespace app\controllers;

use app\models\Counter;
use Yii;
use app\models\Hrefshort;
use yii\helpers\Url;

class ShortController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $error = '';
        $href_long = '';

        $ip =  Yii::$app->request->getUserIP();

        $current_url = Url::to('', true);

        $model = Hrefshort::find()->where(['href_short' => $current_url])->one();

        if(isset($model->href_long) && !empty($model->href_long)) {
            $href_long = $model->href_long;

            if(!empty($ip)) {

                $counter = Counter::find()->where(['ip' => $ip])->one();

                if(isset($counter->ip)) {
                    $counter->count++;
                    $counter->save();
                }
                else {
                    $counter_add = new Counter();
                    $counter_add->hrefshort_id = $model->id;
                    $counter_add->ip = $ip;
                    $counter_add->count = 1;
                    $counter_add->save();
                }

                Yii::info('По ссылке ' . $model->href_short . ' перешел пользователь с ip = ' . $ip, __METHOD__);
            }
        }
        else {
            $error = 'Ошбика! Короткий URL в базе не найден!';
        }

        return $this->render('index', [
            'error' => $error,
            'href_long' => $href_long,
        ]);
    }

}
