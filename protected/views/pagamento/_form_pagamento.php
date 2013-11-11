<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'pagar-form',
    'enableAjaxValidation'=>false,
    'action'=>$this->createUrl('pagamento/alterar', array('id'=>$model->idPagamento))
)); ?>
    <?php if($model->tipo == 'C'):?>
        <div class="clearfix">
            <p class="span10"><label>Aluno: <?php echo $cabecalho->idAluno0->nome;?></label></p>
        </div>
        <div class="clearfix">
            <p class="span3"><label>Modalidade: <?php echo $cabecalho->idModalidade0->descricao;?></label></p>
            <p class="span3"><label>Vencimento: <?php echo Formatacao::formatData($model->dtVencimento);?></label></p>
            <p class="span4"><label>Valor a Receber (R$): <?php echo number_format($model->valorPagar,2,',','.');?></label></p>
        </div>
    <?php else:?>
        <div class="clearfix">
            <p class="span3"><label>Conta: <?php echo $cabecalho->nome;?></label></p>
            <p class="span3"><label>Vencimento: <?php echo Formatacao::formatData($model->dtVencimento);?></label></p>
            <p class="span4"><label>Valor a Pagar (R$): <?php echo number_format($model->valorPagar,2,',','.');?></label></p>
        </div>
    <?php endif;?>
    <div class="clearfix">
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'valorPago',array('class'=>'span12'));?>
        </div>
        <div class="span3">
            <?php echo $form->dropdownListRow($model,'idFormaPgto',$formasPgto,array('class'=>'span12', 'prompt'=>'Selecione'));?>
        </div>
    </div>
    <div class="clearfix" id="divPgtoCheque" style="display: none">
        <?php $this->renderPartial('application.views.cheque._form', array('model'=>$modelCheque,'bancos'=>$bancos, 'form'=>$form));?>
    </div>
<?php $this->endWidget(); ?>

<script>
    $(function(){
        $('#Pagamento_idFormaPgto').change(function(){
            var idForma = $(this).val();

            if(idForma == 1)
            {
                $('#divPgtoCheque').show();
            }
            else
            {
                $('#divPgtoCheque').hide();
            }
        });
    })
</script>