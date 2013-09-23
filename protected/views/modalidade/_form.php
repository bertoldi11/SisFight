<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'modalidade-form',
	'enableAjaxValidation'=>false,
	'action'=>($model->isNewRecord) ? $this->createUrl('modalidade/novo') : $this->createUrl('modalidade/alterar', array('id'=>$model->idModalidade))
)); ?>
	<div class="clearfix">
		<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
		
		<?php echo $form->errorSummary($model); ?>
	</div>
	<div class="clearfix">
		<div class="pull-left span4">
			<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span12','maxlength'=>60)); ?>
		</div>
		<div class="pull-left span1">
			<?php echo $form->dropDownListRow($model,'status',Yii::app()->params['status'],array('class'=>'span12')); ?>
		</div>
	</div>
	<div class="clearfix">
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>$model->isNewRecord ? 'Salvar' : 'Alterar',
				)); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
