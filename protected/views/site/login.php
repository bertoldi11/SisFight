<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="box-content span11">
    <fieldset>
        <legend>Login</legend>
        <div class="form">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'login-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )); ?>

                <p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>
                <div class="span12">
                    <div class="row">
                        <?php echo $form->textFieldRow($model,'username'); ?>
                        <?php echo $form->error($model,'username'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->passwordFieldRow($model,'password'); ?>
                        <?php echo $form->error($model,'password'); ?>
                    </div>

                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Entrar',array('class'=>'btn btn-primary ')); ?>
                    </div>
                </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </fieldset>
</div>