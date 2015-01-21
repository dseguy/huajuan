<?php
namespace app\modules\user\controllers\api;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\user\models\Favorite;
use app\components\ControllerTrait;
use app\modules\question\components\ControllerTrait as QuestionControllerTrait;

class FavoriteController extends Controller
{
    use ControllerTrait;
    use QuestionControllerTrait;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    public function actionQuestion($id)
    {
        $question = $this->findQuestion($id);
        $user = Yii::$app->user->getIdentity();

        list($result, $like) = Favorite::Question($user, $question);

        if ($result) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($like ? $like->getErrors() : '提交失败!');
        }
    }
}