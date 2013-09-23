<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'turma-form',
	'enableAjaxValidation'=>false,
	'action'=>($model->isNewRecord) ? $this->createUrl('turma/novo') : $this->createUrl('turma/alterar', array('id'=>$model->idTurma))
)); ?>
	<div class="clearfix">
		<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
		
		<?php echo $form->errorSummary($model); ?>
		<?php echo $form->dropDownListRow($model,'idModalidade',$dataModalidades,array('class'=>'span3','prompt'=>'Selecione')); ?>
	</div>
	<div class="clearfix">
		<div class="pull-left span2">
			<?php echo $form->timepickerRow($model,'inicio',array('class' => 'span12','options'=>array('showMeridian'=>false))); ?>
		</div>
		<div class="pull-left span2">	
			<?php echo $form->timepickerRow($model,'termino',array('class' => 'span12', 'options'=>array('showMeridian'=>false))); ?>
		</div>
	</div>
	<div class="clearfix">
		<div class="pull-left span2">
			<?php echo $form->textFieldRow($model,'capacidade',array('class'=>'span11')); ?>
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
