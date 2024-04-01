<?php

use yii\helpers\Html;

$this->title = 'User List';
?>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= Html::encode($user->username) ?></td>
                    <td><?= Html::encode($user->email) ?></td>
                    <td>
                        <?= Html::a('Edit', ['user/update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['user/delete', 'id' => $user->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this user?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        
                        <?= Html::a('Download PDF', ['user/generate-user', 'id' => $user->id], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>


                    </td>
                </tr>
                
            <?php endforeach; ?>
        </tbody>

        <?= Html::a('Download PDF', ['user/generate-pdf'], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
</div>
