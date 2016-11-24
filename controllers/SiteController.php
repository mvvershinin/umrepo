<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Profile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionAdmin()
    {
        return $this->render('admin');
    }
    public function actionGenerate()
    {
        $firstn = array(
'Давид', 'Даниил', 'Данила', 'Данила', 'Дементий', 'Демид', 'Демьян', 'Денис', 'Дмитрий', 'Добромысл', 'Доброслав', 'Евгений', 'Евграф', 'Евдоким', 'Евлампий', 'Евсей', 'Евстафий', 'Евстигней', 'Егор', 'Елизар', 'Елисей', 'Емельян', 'Иван', 'Игнат', 'Игнатий', 'Игорь', 'Измаил', 'Изот', 'Изяслав', 'Иларион', 'Кирилл', 'Лавр', 'Лаврентий', 'Лев', 'Леон', 'Леонид', 'Леонтий',  'Макар', 'Максим', 'Максимилиан', 'Максимильян', 'Мануил', 'Мариан', 'Марк', 'Мартин', 'Мартын', 'Мартьян', 'Матвей', 'Мефодий', 'Мирослав', 'Митрофан', 'Михаил', 'Назар', 'Наркис', 'Натан', 'Наум', 'Нестор', 'Нестер', 'Никандр', 'Никанор' 
        );
        $lastn = array(
        'Суханов', 'Миронов', 'Дан', 'Александров', 'Коновалов', 'Шестаков', 'Казаков', 'Ефимов', 'Денисов', 'Хромов', 'Фомин', 'Давыдов', 'Мельников', 'Щербаков', 'Блинов', 'Колесников', 'Карпов', 'Афанасьев', 'Власов', 'Маслов', 'Исаков', 'Тихонов', 'Аксёнов', 'Гаврилов', 'Родионов', 'Котов', 'Горбунов', 'Кудряшов', 'Быков', 'Зуев', 'Третьяков', 'Савельев', 'Летов', 'Рыбаков', 'Суворов', 'Абрамов', 'Воронов', 'Мухин', 'Архипов', 'Доронин', 'Белозёров', 'Рожков', 'Самсонов', 'Мясников', 'Лихачёв', 'Буров', 'Сысоев', 'Трофимов', 'Мартынов', 'Емельянов'
        );    
        $about = 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.."';
        for($i = 1; $i <= 10000; $i++)
        {
            $name = array_rand($firstn);
            $lname = array_rand($lastn);
            $model = new Profile();
            $model->uid = rand(28, 30);
            $model->avatar = md5($model->uid. time()) . '.jpg';
            $model->firstname = $firstn[$name];
            $model->patronymic = '';
            $model->lastname = $lastn[$lname];
            $model->gender = 'мужской';
            $model->about = $about;
            $model->is_master = true;
            $model->location_place_id = 70;
            $model->work_place_id = 70;
            $model->save();
            //return $this->render('admin');
            //return $name[];
        }
    }
}
