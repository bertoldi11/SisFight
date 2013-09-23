<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
	'action'=>($model->isNewRecord) ? $this->createUrl('usuario/novo') : $this->createUrl('usuario/alterar', array('id'=>$model->idUsuario))
)); ?>
<div class="clearfix">
	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
	
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>100)); ?>	
	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>150)); ?>
</div>
<div class="clearfix">
	<div class="pull-left">
		<?php echo $form->datepickerRow($model,'dtNasc',array(
				'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
				'prepend' => '<i class="icon-calendar"></i>',
				'class'=>'span11'
			)
		); ?>
	</div>
	<div class="pull-left span3">
		<?php 
			if($model->isNewRecord)
				echo $form->passwordFieldRow($model,'senha',array('class'=>'span11','maxlength'=>10)); 
			else
				echo $form->passwordFieldRow($model,'senha',array('class'=>'span11','maxlength'=>10,'disabled'=>'true')); 
			?>
		
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
