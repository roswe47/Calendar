<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Access */

$this->title = Yii::t('app', 'Create Access');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'My friends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'all_users' => $all_users,
        'all_mynotes' => $all_mynotes,
    ]) ?>

</div>
