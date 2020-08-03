<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii2mod\editable\EditableColumn;
use yii2mod\settings\models\enumerables\SettingStatus;
use yii2mod\settings\models\enumerables\SettingType;
use yii2mod\settings\models\SettingModel;
use yii\bootstrap4\ActiveForm;

/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \yii2mod\settings\models\search\SettingSearch */

$this->title = Yii::t('yii2mod.settings', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">
    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php Pjax::begin(['timeout' => 10000, 'enablePushState' => false]); ?>

    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo '<br />'.Html::submitButton(Yii::t('yii2mod.settings', 'Update'), ['class' => 'btn btn-primary']).'<br /><br />';
        foreach ($searchModel as $k=>$sett){
//            var_dump($sett);die;
            ?>
            <div class="form-group field-settings-sitename">
                <label class="control-label" for="settings-sitename"><?=empty($sett->description) ? $sett->key : '<b>'.$sett->description.'</b>'?></label>
                <?php if($sett->type!='string'){ ?>
                <input type="text" id="settings-sitename" class="form-control" name="Settings[<?=$sett->section?>][<?=$sett->key?>]" value="<?=$sett->value?>">
                <?php }else{ ?>
                <textarea type="text" id="settings-sitename" class="form-control" name="Settings[<?=$sett->section?>][<?=$sett->key?>]"><?=$sett->value?></textarea>
                <?php } ?>
                <p class="help-block help-block-error"></p>
            </div>
    <?php
        }
    echo Html::submitButton(Yii::t('yii2mod.settings', 'Update'), ['class' => 'btn btn-primary']);

    ?>
    <?php ActiveForm::end(); ?>
<!--    --><?php //echo GridView::widget([
//            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
//            'columns' => [
//                [
//                    'class' => 'yii\grid\SerialColumn',
//                ],
//                [
//                    'attribute' => 'type',
//                    'filter' => SettingType::listData(),
//                    'filterInputOptions' => ['prompt' => Yii::t('yii2mod.settings', 'Select Type'), 'class' => 'form-control'],
//                ],
//                [
//                    'attribute' => 'section',
//                    'filter' => ArrayHelper::map(SettingModel::find()->select('section')->distinct()->all(), 'section', 'section'),
//                    'filterInputOptions' => ['prompt' => Yii::t('yii2mod.settings', 'Select Section'), 'class' => 'form-control'],
//                ],
//                'key',
//                'value:ntext',
//                [
//                    'class' => EditableColumn::class,
//                    'attribute' => 'status',
//                    'url' => ['edit-setting'],
//                    'value' => function ($model) {
//                        return SettingStatus::getLabel($model->status);
//                    },
//                    'type' => 'select',
//                    'editableOptions' => function ($model) {
//                        return [
//                            'source' => SettingStatus::listData(),
//                            'value' => $model->status,
//                        ];
//                    },
//                    'filter' => SettingStatus::listData(),
//                    'filterInputOptions' => ['prompt' => Yii::t('yii2mod.settings', 'Select Status'), 'class' => 'form-control'],
//                ],
//                'description:ntext',
//                [
//                    'header' => Yii::t('yii2mod.settings', 'Actions'),
//                    'class' => 'yii\grid\ActionColumn',
//            'buttons'=>[
//                'update' => function ($url, $model) {
//                    return Html::a('<svg class="bi bi-pencil-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
//  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
//  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
//</svg>', $url, [
//                        'title' => \Yii::t('app', 'update')
//                    ]);
//                },
//                'delete' => function ($url, $model) {
//                    return Html::a('<svg class="bi bi-trash-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
//  <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
//</svg>', $url, [
//                        'title' => \Yii::t('app', 'delete'),
//                        'data-confirm' => \Yii::t('yii', 'Вы точно хотите удалить?'),
//                        'data-method' => 'post',
//                    ]);
//                }
//            ],
//                    'template' => '{update} {delete}',
//                ],
//            ],
//        ]
//    ); ?>
<!--    --><?php //Pjax::end(); ?>
</div>
