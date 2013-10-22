<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tipoaluno-form',
	'enableAjaxValidation'=>false,
    'action'=>($model->isNewRecord) ? $this->createUrl('tipoaluno/novo') : $this->createUrl('tipoaluno/alterar', array('id'=>$model->idTipoAluno))
)); ?>
    <div class="clearfix">
        <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="clearfix">
        <div class="pull-left span3">
            <?php echo $form->textFieldRow($model,'descricao',array('class'=>'span12','maxlength'=>20)); ?>
        </div>
        <div class="pull-left span2">
            <?php echo $form->textFieldRow($model,'quantParcelas',array('class'=>'span12')); ?>
        </div>
        <div class="pull-left span2">
            <?php echo $form->dropdownListRow($model,'geraPagamento',Yii::app()->params['sim_nao'],array('class'=>'span12','prompt'=>'selecione')); ?>
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
