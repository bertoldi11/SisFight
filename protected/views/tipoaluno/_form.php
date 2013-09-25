<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tipoaluno-form',
	'enableAjaxValidation'=>false,
    'action'=>($model->isNewRecord) ? $this->createUrl('tipoaluno/novo') : $this->createUrl('tipoaluno/alterar', array('id'=>$model->idTipoAluno))
)); ?>

    <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

    <?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span5','maxlength'=>45)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Salvar' : 'Alterar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
