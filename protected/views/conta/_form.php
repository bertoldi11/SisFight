<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'conta-form',
	'enableAjaxValidation'=>false,
    'action'=>($model->isNewRecord) ? $this->createUrl('conta/novo') : $this->createUrl('conta/alterar', array('id'=>$model->idConta))
)); ?>
    <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>100)); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>$model->isNewRecord ? 'Salvar' : 'Alterar',
            )); ?>
    </div>
<?php $this->endWidget(); ?>