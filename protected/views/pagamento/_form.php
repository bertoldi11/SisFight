<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pagamento-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos com <span class="required">*</span> São obrigatórios.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'valor',array('class'=>'span5','maxlength'=>6)); ?>

    <?php echo $form->dropdownListRow($model,'mesRef',Yii::app()->params['meses'],array('class'=>'span5')); ?>

    <?php echo $form->dropdownListRow($model,'anoRef',Yii::app()->params['anos'],array('class'=>'span5')); ?>

    <?php echo $form->datepickerRow($model,'dtPagamento',array(
            'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
            'prepend' => '<i class="icon-calendar"></i>',
        )
    ); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
