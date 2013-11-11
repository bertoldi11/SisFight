<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'banco-form',
	'enableAjaxValidation'=>false,
    'action'=>($model->isNewRecord) ? $this->createUrl('banco/novo') : $this->createUrl('banco/alterar', array('id'=>$model->idBanco))
)); ?>
    <div class="clearfix">
        <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="clearfix">
        <div class="span2">
            <?php echo $form->textFieldRow($model,'codFebraban',array('class'=>'span12','maxlength'=>5)); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model,'nome',array('class'=>'span12','maxlength'=>100)); ?>
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
