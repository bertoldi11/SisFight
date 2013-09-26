<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'alunocontato-form',
	'enableAjaxValidation'=>false,
    'action'=> ($model->isNewRecord) ? $this->createUrl('alunocontato/novo', array('id'=>$idAluno)) : $this->createUrl('alunocontato/alterar', array('id'=>$model->idAlunoContato))
)); ?>

<?php
$mostraFormContato = '';
$dadosContato = array('classe'=>'','prefixo'=>'','mascara'=>'');
if($model->isNewRecord)
{
    if(!$model->hasErrors())
    {
        $mostraFormContato = 'style="display: none"';
    }

}
else
{
    $dadosContato = array(
        'classe'=>$model->idTipoContato0->classe,
        'prefixo' => $model->idTipoContato0->prefixo,
        'mascara' => $model->idTipoContato0->mascara
    );
}
?>
<?php echo $form->errorSummary($model); ?>
<div class="clearfix">
    <?php
    $tiposContato = CHtml::listData(Tipocontato::model()->findAll(), 'idTipoContato', 'descricao');
    echo $form->dropDownListRow($model,'idTipoContato', $tiposContato, array('class'=>'span2', 'prompt'=>'Selecione'));
    ?>

</div>
<div <?php echo $mostraFormContato;?> id="divDadosContato">
    <div class="clearfix">
        <div class="pull-left" style="padding-top: 30px; margin-right:10px; vertical-align: baseline;">
            <i id="imagemContato" class="<?php echo $dadosContato['classe'];?>"></i>
        </div>
        <div class="pull-left" id="divContatoValor" style="width: auto;">
            <?php if(!empty($dadosContato['mascara']))
            {
                echo $form->labelEx($model,'contato');
                $this->widget('CMaskedTextField', array(
                    'model'=>$model,
                    'attribute'=>'contato',
                    'mask' => $dadosContato['mascara'],
                    'htmlOptions' => array('class'=>'span11')
                ));
            }
            else
            {
                echo $form->textFieldRow($model,'contato',array('class'=>'span11','maxlength'=>30));
            }
            ?>
        </div>
        <div class="pull-left" style="width: 30%;">
            <?php echo $form->textFieldRow($model,'complemento',array('class'=>'span11','maxlength'=>60,'placeholder'=>'Ex.: Deixar recado com Maria.')); ?>
        </div>
        <div class="pull-left" style="padding-top: 30px;">
            <?php echo $form->checkBoxRow($model,'default', array('value'=>'S', 'uncheckValue'=>'N')); ?>
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
</div>
<?php $this->endWidget(); ?>

<hr>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'template'=>"{items}",
    'dataProvider'=>$dataProviderContatos,
    'columns'=>array(
        array('name'=> 'idTipoContato0.descricao', 'header'=>'Tipo de Contato'),
        array('name'=> 'contato', 'header'=>'Contato'),
        array('name'=> 'complemento', 'header'=>'Complemento'),
        array(
            'htmlOptions' => array('nowrap'=>'nowrap'),
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update} {delete}',
            'updateButtonUrl'=>'Yii::app()->createUrl("alunocontato/alterar", array("id"=>"$data->idAlunoContato"))',
            'deleteButtonUrl'=>'Yii::app()->createUrl("alunocontato/delete", array("id"=>"$data->idAlunoContato"))',
        )
    ),
));?>

<script>
    $(function(){
        $('#Alunocontato_idTipoContato').change(function(e){
            var idTipoContato = $(this).val();

            if(idTipoContato > 0)
            {
                $.ajax({
                    url: '<?php echo Yii::app()->request->baseUrl; ?>/tipocontato/alterar.html',
                    dataType: 'json',
                    type: 'get',
                    data: {reqAjax: true, id: idTipoContato},
                }).done(function(JSON){
                        if(JSON.prefixo){
                            $('#divContatoValor').empty();
                            $('#divContatoValor').css('width','35%');
                            $('#divContatoValor').css('margin-right','10px');
                            $('#divContatoValor').prepend('<label class="required" for="Alunocontato_contato"> Contato </label> <div class="input-prepend"><span class="add-on">'+JSON.prefixo+'</span><input type="text" id="Alunocontato_contato" name="Pessoacontato[contato]" class="span5"></div>');
                        }
                        else{
                            $('#divContatoValor').empty();
                            $('#divContatoValor').css('width','auto');
                            $('#divContatoValor').append('<label class="required" for="Alunocontato_contato"> Contato </label><input type="text" id="Alunocontato_contato" name="Alunocontato[contato]" maxlength="30" class="span11">');
                        }

                        if(JSON.mascara){
                            $("#Alunocontato_contato").mask(JSON.mascara);
                        }
                        $('#imagemContato').removeClass();
                        $('#imagemContato').addClass(JSON.classe).addClass('icon-large');
                        $('#divDadosContato').show();
                    });
            }
            else
            {
                alert('Selecione um tipo de Contato.');
                $('#divDadosContato').hide();
            }

        });

    });

</script>