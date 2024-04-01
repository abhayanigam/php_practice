<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\forms\RegistrationForm;

class UserController extends Controller
{
    public function actionRegister()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password = Yii::$app->security->generatePasswordHash($model->password);

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Registration successful.');
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to register user.');
            }
        }

        return $this->render('register', ['model' => $model]);
    }

    public function actionList()
    {
        $users = User::find()->all();
        return $this->render('list', ['users' => $users]);
    }

}
