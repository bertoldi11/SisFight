<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pagamento-form',
	'enableAjaxValidation'=>false,
    'action'=>$this->createUrl('pagamento/novo')
)); ?>
    <div class="clearfix">
        <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="clearfix row-fluid">
        <div class="span3">
            <?php echo $form->dropdownListRow($model,'idConta',$modelContas,array('class'=>'span12', 'prompt'=>'Selecione')); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'valorPagar',array('class'=>'span11','maxlength'=>10)); ?>
        </div>
        <div class="span3">
            <?php echo $form->datepickerRow($model,'dtVencimento',array(
                    'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
                    'prepend' => '<i class="icon-calendar"></i>',
                    'class'=>'span11'
                )
            ); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
