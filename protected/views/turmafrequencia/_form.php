<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'turmafrequencia-form',
	'enableAjaxValidation'=>false,
    'action'=>$this->createUrl('turmafrequencia/novo'),
)); ?>
    <div class="clearfix">
        <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="clearfix">
        <div class="pull-left span3">
            <?php echo $form->dropdownListRow($model,'idTurma',$turmas,array('class'=>'span12', 'prompt'=>'Selecione')); ?>
        </div>
        <div class="pull-left span2">
            <?php echo $form->dropdownListRow($model,'mes',Yii::app()->params['meses'],array('class'=>'span12', 'prompt'=>'Selecione')); ?>
        </div>
        <div class="pull-left span2">
            <?php echo $form->dropdownListRow($model,'ano',Yii::app()->params['anos'],array('class'=>'span12', 'prompt'=>'Selecione')); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Salvar',
                )); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
