<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use app\models\User;
use app\models\forms\RegistrationForm;
use app\models\forms\LoginForm;
use Dompdf\Dompdf;
use yii\web\NotFoundHttpException;
use Dompdf\Options;
use app\models\forms\WeatherForm;

class UserController extends Controller
{
    public function actionRegister()
    {
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON
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

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Perform login authentication here
            Yii::$app->session->setFlash('success', 'Login successful.');
            return $this->redirect(['site/index']);
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $users = User::find()->all();
        return $users;
    }

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        $model = new RegistrationForm();

        if ($user === null) {
            throw new \yii\web\NotFoundHttpException('User not found.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password = Yii::$app->security->generatePasswordHash($model->password);

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'User updated successfully.');
                return $this->redirect(['user/list']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update user.');
            }
        }

        $model->username = $user->username;
        $model->email = $user->email;

        return $this->render('update', ['model' => $model, 'user' => $user]);
    }

    public function actionDelete($id)
    {
        $user = User::findOne($id);

        if ($user === null) {
            throw new \yii\web\NotFoundHttpException('User not found.');
        }

        if ($user->delete()) {
            Yii::$app->session->setFlash('success', 'User deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete user.');
        }

        return $this->redirect(['user/list']);
    }

    public function actionGeneratePdf()
    {
        // Fetch user data from the database or any other source
        $userData = User::find()->all();

        // Load the HTML template for the PDF
        $content = $this->renderPartial('pdf-template', ['userData' => $userData]);

        // Setup dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
       
        // Instantiate dompdf
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($content);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to browser (inline)
        return $dompdf->stream('user_profile.pdf');
    }

    public function actionGenerateUser($id)
    {
        $user = User::findOne($id);

        if ($user !== null) {
            // Load the view file for the PDF content
            $content = $this->renderPartial('pdf', ['user' => $user]);

            // Generate PDF using DOMPDF
            $pdf = new Dompdf();
            $pdf->loadHtml($content);
            $pdf->render();

            // Output the generated PDF to the browser
            $pdf->stream("user_profile_{$user->id}.pdf");
        } else {
            throw new NotFoundHttpException('The requested user does not exist.');
        }
    }

    public function actionWeather()
{
    $model = new WeatherForm();

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $weatherData = $this->getWeatherData($model->location);
        $postalData = $this->getPostalData($model->postalCode); // Fetch postal data
        return $this->render('weather', ['weatherData' => $weatherData, 'postalData' => $postalData]);
    }

    return $this->render('index', ['model' => $model]);
}

    private function getWeatherData($location)
    {
        $apiKey = 'c5fc22a5d61346b3beb191712240204'; // Replace with your WeatherAPI API key
        $url = "https://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$location}";

        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    private function getPostalData($postalCode)
{
    $postalData = []; // Initialize $postalData variable

    $apiUrl = 'http://www.postalpincode.in/api/pincode/' . $postalCode;
    
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response, true);
        if (!empty($data['PostOffice'][0])) {
            $postalData['city'] = $data['PostOffice'][0]['District'];
            $postalData['state'] = $data['PostOffice'][0]['State'];
            $postalData['country'] = $data['PostOffice'][0]['Country'];
        }
    }
    
    return $postalData;
}
}
