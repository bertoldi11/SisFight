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
            <?php echo $form->datePickerRow($model,'data',array('class'=>'span12',
                'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
                'prepend' => '<i class="icon-calendar"></i>',)); ?>
        </div>
        <div class="pull-left span2" style="margin-top: 25px;">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>'Salvar',
            )); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
