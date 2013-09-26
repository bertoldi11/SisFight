<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pagamento-form',
	'enableAjaxValidation'=>false,
    'action'=>$this->createUrl('pagamento/novo'),
)); ?>
    <div class="clearfix">
        <p class="help-block">Campos com <span class="required">*</span> São obrigatórios.</p>
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="clearfix">
        <div class="pull-left" style="margin-right: 10px;">
            <?php echo $form->textFieldRow($model,'valorPagar',array('maxlength'=>6)); ?>
        </div>
        <div class="pull-left">
            <?php echo $form->datepickerRow($model,'dtPagamento',array(
                    'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
                    'prepend' => '<i class="icon-calendar"></i>',
                )
            ); ?>
        </div>
    </div>
    <input type="hidden" name="Pagamento[idAlunoTurma]" id="Pagamento_idAlunoTurma" value="" />
<?php $this->endWidget(); ?>
