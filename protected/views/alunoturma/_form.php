<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'alunoturma-form',
	'enableAjaxValidation'=>false,
    'action'=> ($model->isNewRecord) ? $this->createUrl('alunoturma/novo', array('id'=>$idAluno)) : $this->createUrl('alunoturma/alterar', array('id'=>$model->idAlunoTurma))
)); ?>
<div class="clearfix">
    <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>
    <?php echo $form->errorSummary($model); ?>
</div>

<div class="clearfix">
    <div class="pull-left span2">
	    <?php echo $form->dropdownListRow($model,'idTurma',$modelDescTurma,array('class'=>'span12', 'prompt'=>'selecione')); ?>
    </div>
    <div class="pull-left  span2">
	    <?php echo $form->dropdownListRow($model,'idTipoAluno',$modelTiposAluno,array('class'=>'span12', 'prompt'=>'selecione')); ?>
    </div>
    <div class="pull-left  span2">
	    <?php echo $form->textFieldRow($model,'valor',array('class'=>'span12','maxlength'=>6)); ?>
    </div>
    <div class="pull-left  span2">
        <?php echo $form->dropdownListRow($model,'status',Yii::app()->params['status'],array('class'=>'span12','maxlength'=>6)); ?>
    </div>
    <div class="pull-left  span2" style="padding-top: 25px;">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? 'Salvar' : 'Alterar',
        )); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<hr>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'template'=>"{items}",
    'dataProvider'=>$dataProviderTurma,
    'columns'=>array(
        array('name'=> 'idTurma0.idModalidade0.descricao', 'header'=>'Turma', 'value'=>'$data->idTurma0->idModalidade0->descricao." - ".substr($data->idTurma0->inicio,0,5)." as ".substr($data->idTurma0->termino,0,5)'),
        array('name'=> 'idTipoAluno0.descricao', 'header'=>'Tipo Aluno'),
        array('name'=> 'valor', 'header'=>'Valor', 'value'=>'number_format($data->valor,2,",",".")'),
        array('name'=> 'status', 'header'=>'Status','value'=>'($data->status == "A") ? "Ativo" : "Inativo"'),
        array(
            'htmlOptions' => array('nowrap'=>'nowrap'),
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update} {delete}',
            'updateButtonUrl'=>'Yii::app()->createUrl("alunoturma/alterar", array("id"=>"$data->idAlunoTurma"))',
            'deleteButtonUrl'=>'Yii::app()->createUrl("alunoturma/delete", array("id"=>"$data->idAlunoTurma"))',
        )
    ),
));?>
