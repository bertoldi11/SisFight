<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'formapgto-form',
	'enableAjaxValidation'=>false,
    'action'=>($model->isNewRecord) ? $this->createUrl('formapgto/novo') : $this->createUrl('formapgto/alterar', array('id'=>$model->idFormaPgto))
)); ?>
    <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

    <?php echo $form->errorSummary($model); ?>
    <div class="clearfix">
        <div class="span3">
            <?php echo $form->textFieldRow($model,'descricao',array('class'=>'span12','maxlength'=>45)); ?>
        </div>
        <div class="span2">
            <?php echo $form->dropdownListRow($model,'status',Yii::app()->params['status'],array('class'=>'span12','maxlength'=>100)); ?>
        </div>
    </div>



    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>$model->isNewRecord ? 'Salvar' : 'Alterar',
            )); ?>
    </div>
<?php $this->endWidget(); ?>