<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tipocontato-form',
	'enableAjaxValidation'=>false,
	'action'=>($model->isNewRecord) ? $this->createUrl('tipocontato/novo') : $this->createUrl('tipocontato/alterar', array('id'=>$model->idTipoContato))
)); ?>
	<div class="clearfix">
		<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
		
		<?php echo $form->errorSummary($model); ?>
	
		<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span4','maxlength'=>20)); ?>
	</div>
	<div class="clearfix">
		<div class="pull-left span2">
			<?php echo $form->textFieldRow($model,'prefixo',array('class'=>'span12','maxlength'=>70)); ?>
		</div>
		<div class="pull-left span2">
			<?php echo $form->textFieldRow($model,'mascara',array('class'=>'span12','maxlength'=>20,'placeholder'=>'Ex.: (99) 9999-9999')); ?>
		</div>
	</div>
	<div class="clearfix">
		<div class="pull-left span2">
			<?php echo $form->textFieldRow($model,'classe',array('class'=>'span12','maxlength'=>25)); ?>
		</div>
		<div class="pull-left span2">
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
