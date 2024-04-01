# CRUD in PHP

### To Create YII Project use command

composer create-project --prefer-dist yiisoft/yii2-app-basic basic

### Create a UserController with the following action

```php
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
            **$user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password = Yii::$app->security->generatePasswordHash($model->password);

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Registration successful.');
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to register user.');
            }**
        }

        return $this->render('register', ['model' => $model]);
    }

		public function actionList(){
		    $users = User::find()->all();
		    return $this->render('list', ['users' => $users]);
		}

}
```

### Create a view file **`register.php`** under **`views/user/`** directory to render the registration form.

```php
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Register';

$form = ActiveForm::begin([
    'id' => 'registration-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'email')->textInput() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
```

### Create a view file **`list.php`** under **`views/user/`** directory to render the user list.

In **`list.php`**, you can iterate over **`$users`** and display the user details.

```php
<?php

use yii\helpers\Html;

$this->title = 'User List';

foreach ($users as $user) {
    echo Html::encode($user->username) . "<br>";
    echo Html::encode($user->email) . "<br><br>";
}
```

### **`User`** model class that includes attributes, table name, validation rules, and other relevant configurations

```php
<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users'; // Assuming the table name is 'user'
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            // Add other attribute labels as needed
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Additional logic before saving for new records
            }
            // Additional logic before saving for existing records
            return true;
        }
        return false;
    }
}
```

- Definition of table name.
- Validation rules for username, email, and password fields.
- Attribute labels.
- Timestamp behavior to automatically set **`created_at`** and **`updated_at`** fields.
- Static method **`findByUsername`** to find a user by their username.
- Method **`validatePassword`** to validate the user's password.
- Validation rules for username, email, and password fields.
- Attribute labels.
- Method **`beforeSave()`** which can be overridden to add additional logic before saving a record. In this example, it's used to handle timestamps or any other pre-save logic.

### Create **`RegistrationForm`** Model under **`models/forms/`** directory to render the registration form

```php
<?php

namespace app\models\forms;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            [['username'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            [['password'], 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
```

### Create a form view **`register.php`** under **`views/user/`** directory

```php
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Register';

$form = ActiveForm::begin([
    'id' => 'registration-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'email')->textInput() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
```

### Create a form view **`list.php`** under **`views/user/`** directory

```php
<?php

use yii\helpers\Html;

$this->title = 'User List';

foreach ($users as $user) {
    echo Html::encode($user->username) . "<br>";
    echo Html::encode($user->email) . "<br><br>";
}
```

### Configure routing in the Yii application

In **`config/web.php`**, add the following rules to define routing for UserController

```php
<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'RfV7hgF6LdN9AFCgXk3xK01NNxwI29Xi',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'user/register' => 'user/register',
                'user/list' => 'user/list',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
```

- Registration form: [http://localhost:8080/user/register](http://localhost:8080/user/register)
- User listing: [http://localhost:8080/user/list](http://localhost:8080/user/list)

## Steps to define a database in the project:

**Configure Database Connection**: Open the **`config/db.php`** file and configure your database connection settings. You need to provide details such as **`dsn`**, **`username`**, **`password`**, and **`charset`**. For example:

```php
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=config_users',
    'username' => 'root',
    'password' => '',  /*------ password according to the xampp server mysql*/
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
```

### **Create Database Tables**:

You need to create the necessary tables in your database. Yii supports migrations to manage database schema changes. You can generate migration files using Yii's command-line tool. For example, to create a migration for the **`user`** table, you can run

```php
./yii migrate/create create_user_table
```

- Note (CHECK)
    
    **Accessing Database**: Once you've defined the models, you can access the database in your application logic, such as controllers or views, to perform CRUD (Create, Read, Update, Delete) operations.
    
    For example, to fetch all users from the **`user`** table, you can use the following code in your controller:
    
    ```php
    $users = User::find()->all();
    ```
    

### Now, try running the migration command again:

```bash

./yii migrate/create users
```

### How to check it ?

After creating a new migration using the `./yii migrate/create users` command, you have successfully generated a migration file named `m240401_084940_users.php` in the `migrations` directory of your Yii project.

To check the details of this migration file or to verify its contents, you can navigate to the `migrations` directory in your project. In your case, it should be located at `C:\\Users\\abhay\\Desktop\\basic\\migrations`.

Open the `m240401_084940_users.php` file using a text editor or an IDE. Inside this file, you will find the migration class definition with `up()` and `down()` methods. The `up()` method defines the changes that will be applied to the database when you run the migration, while the `down()` method defines the actions to revert those changes in case you need to rollback the migration.

Here's an example of what the migration file might look like:

```php
<?php

use yii\\db\\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240401_084940_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            // Add other columns as needed
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}

```

This migration file creates a new table named `users` with columns for `id`, `username`, `email`, and `password`. You can customize this migration file according to your database schema requirements.

Once you have reviewed the migration file and made any necessary changes, you can apply the migration to your database using the `./yii migrate` command:

```
./yii migrate
```

This command will execute all pending migrations, including the one you just created, and apply the changes to your database schema.

### Why it is showing migration table, The reason of migration table ?

In Yii, the migration table is a system table used to keep track of the migrations that have been applied to the database. It stores metadata about each migration, such as the migration name and the timestamp when it was applied.

The migration table is automatically created by Yii when you first run migrations on your project. It typically has a name like `{{%migration}}` and consists of columns to store migration information.

Here's why the migration table is created and its purpose:

1. **Tracking Applied Migrations**: The migration table keeps track of which migrations have already been applied to the database. Each time you run migrations, Yii checks this table to determine which migrations need to be executed. This helps ensure that migrations are only applied once and prevents applying the same migration multiple times.
2. **Reverting Migrations**: In addition to applying migrations, Yii's migration system also supports rolling back migrations. The migration table is used to determine the order in which migrations should be reverted. When you run `./yii migrate/rollback`, Yii looks at the migration table to find the latest migration that was applied and then executes the `down()` method of that migration to revert its changes.
3. **Version Control**: The migration table provides a form of version control for your database schema. By keeping track of applied migrations, you can easily see the history of changes made to the database and roll back to previous states if needed.
4. **Consistency Across Environments**: In a team environment or when deploying your application to different environments (e.g., development, staging, production), the migration table ensures that the database schema is consistent across all environments. Each environment can have its own copy of the migration table, allowing migrations to be applied independently.

In summary, the migration table is an essential component of Yii's migration system, facilitating the management and tracking of database schema changes across different environments and ensuring consistency and reliability in your application's database schema evolution.

### (Optional) How to remove My Application ,Home, About ,Contact ,Login in this project

Open the **`config/web.php`** file and remove or comment out the corresponding URL rules

```php
<header id="header">
    <!-- <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    NavBar::end();
    ?> -->
</header>
```
