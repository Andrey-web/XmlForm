<?php

/* @var $this yii\web\View */

use app\models\XmlForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'XML parse';
?>
<div class="site-index">

    <?php if (Yii::$app->session->hasFlash('fileSubmitted')): ?>
    <div class="alert alert-success">
        Файл успешно загружен
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('fileNotSubmitted')): ?>
    <div class="alert alert-danger">
        Файл не соответствует заданным условиям
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('StructureError')): ?>
    <div class="alert alert-danger">
        Ошибка в структуре xml
    </div>
    <?php endif; ?>
    <h3>Загрузить xml файл</h3>
    <?php
    $form = ActiveForm::begin([
        'id' => 'xml-parse-form',
        'options' => ['enctype'=>'multipart/form-data'],
    ]);
    ?>
    <?= $form->field($file, 'file')->label("")->fileInput(['multiple' => false, 'class' => 'fileInput']); ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div style="clear: both"></div>
<?php
if (!empty($newFile)):
?>
<div class="d-table">
    <table id="myTable">
        <thead>
        <tr>
            <th>Id</th>
            <th>Value</th>
            <th>Limit</th>
            <th>Error</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($newFile as $item) { ?>
            <tr>
                <td><?=$item["Id"]?></td>
                <td><?=$item->Value?></td>
                <td><?=$item->Limit?></td>
                <td><?=$item->Error?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php
endif;