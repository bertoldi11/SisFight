<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'aluno-form',
	'enableAjaxValidation'=>false,
    'action'=>($model->isNewRecord) ? $this->createUrl('aluno/novo') : $this->createUrl('aluno/alterar', array('id'=>$model->idAluno))
)); ?>
    <div class="clearfix">
        <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="clearfix">
        <div class="pull-left span4">
            <?php echo $form->textFieldRow($model,'nome',array('class'=>'span12','maxlength'=>100)); ?>
        </div>
        <div class="pull-left span2">
            <?php echo $form->datepickerRow($model,'dtNasc',array(
                    'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
                    'prepend' => '<i class="icon-calendar"></i>',
                )
            ); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="pull-left span3">
            <?php echo $form->textFieldRow($model,'nomeMae',array('class'=>'span12','maxlength'=>100)); ?>
        </div>
        <div class="pull-left span3">
            <?php echo $form->textFieldRow($model,'nomePai',array('class'=>'span12','maxlength'=>100)); ?>
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
