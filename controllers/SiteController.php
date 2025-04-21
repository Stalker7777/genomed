<?php

namespace app\controllers;

use app\models\Hrefshort;
use yii\web\Controller;
use yii\web\Response;
use Da\QrCode\QrCode;
use yii\helpers\Url;
use Yii;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $model = new Hrefshort();

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionGetHrefShort()
    {
        if(Yii::$app->request->isAjax) {
            if (Yii::$app->request->isPost) {
                if (Yii::$app->request->post('Hrefshort')) {

                    $href_long = Yii::$app->request->post('Hrefshort')['href_long'];

                    if($this->isSiteAvailible($href_long)){

                        $model = new Hrefshort();
                        $model->load($this->request->post());

                        $time = time();

                        $model->href_short = Url::toRoute('', true) . $time;
                        $model->href_short = str_replace('get-href-short', '', $model->href_short);

                        $model->qr_image = Url::to('images/' . $time . '.png');

                        $qrCode = (new QrCode($model->href_short))
                            ->setSize(250)
                            ->setMargin(5)
                            ->setBackgroundColor(255, 255, 255);

                        $qrCode->writeFile($model->qr_image);

                        if($model->save()) {
                            $data = [];
                            $data['href_short'] = $model->href_short;
                            $data['qr_image'] = $model->qr_image;

                            return json_encode(['result' => true, 'data' => $data]);
                        }
                        else {
                            $errors = $model->getErrors();
                            return json_encode(['result' => false, 'errors' => implode('<br>', $errors)]);
                        }
                    } else {
                        return json_encode(['result' => false, 'errors' => 'Сайт недоступен']);
                    }
                }
            }
        }

        return json_encode(['result' => false, 'errors' => 'Ошибка! Запрос должен быть AJAX! Метод должен быть POST!']);
    }

    private function isSiteAvailible($url)
    {
        $timeout = 10;
        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
        $http_respond = curl_exec($ch);
        $http_respond = trim( strip_tags( $http_respond ) );
        $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );

        if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
            return true;
        } else {
            return false;
        }
    }
}