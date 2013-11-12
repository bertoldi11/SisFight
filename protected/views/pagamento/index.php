<?php
$this->breadcrumbs=array(
    'Pagamentos',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Pagamentos Alunos</legend>
        <div id="buscaAluno">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'busca-aluno-form',
                'enableAjaxValidation'=>false,
            ));
            ?>
                <label for="aluno">Aluno</label>
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                    'name'=>'aluno',
                    'sourceUrl'=>$this->createUrl('/aluno/buscar'),
                    // additional javascript options for the autocomplete plugin
                    'options'=>array(
                        'select'=>'js:function( event, ui ) {
                            $("#idAluno").val(ui.item.id);
                        }',
                        'minLength'=>'4',
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;',
                        'class'=>'span4'
                    ),
                ));?>
                <button class="btn btn-primary" id="buscarPagamentosAluno"><i class="icon-search"></i></button>
                <input type="hidden" name="idAluno" id="idAluno" />
            <?php $this->endWidget(); ?>
            <div class="span5" style="margin: 0; display: none" id="divTurmas">
                <?php $box = $this->beginWidget(
                    'bootstrap.widgets.TbBox',
                    array(
                        'title' => 'Pagamentos em Aberto',
                        'headerIcon' => 'icon-th-list',
                        'htmlOptions' => array('class' => 'bootstrap-widget-table')
                    )
                );?>
                    <table>
                        <thead>
                        <tr>
                            <th>Turma/Modalidade</th>
                            <th>Vencimento</th>
                            <th>A Receber</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyTurma">

                        </tbody>
                    </table>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'modalPagarConta',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=>'Receber',
            'autoOpen'=>false,
            'modal'=> true,
            'width'=> 710,
            'buttons' => array(
                array('text'=>'Pagar','class'=>'btn btn-primary','click'=> 'js:function(){$("#pagar-form").submit();}'),
                array('text'=>'Cancelar','class'=>'btn','click'=> 'js:function(){$(this).dialog("close");}'),
            ),
        ),
    ));

    echo '<div id="divDadosPagamento" class="row-fluid"></div>';

    $this->endWidget('zii.widgets.jui.CJuiDialog');?>
</div>
<script>
    $(function(){
        $('.cancelarPagamento').live('click', function(event){
            event.preventDefault();

            if(confirm('Deseja Cancelar esse pagamento'))
            {
               var link = $(this);

                $.ajax({
                    url: $(link).attr('href'),
                    type: 'get',
                    dataType: 'json'
                }).done(function(JSON){
                    if(JSON.MSG){
                        alert(JSON.MSG);
                    }

                    if(JSON.SUCESSO){
                        $(link).parent().parent().fadeOut(function(){
                            $(this).remove();
                        });
                    }
                })
            }
        });

        $('.pagarTurma').live('click', function(event){
            event.preventDefault();
            var idPagamento = $(this).attr("data-idPagamento");
            $.ajax({
                url: '<?php echo $this->createUrl("pagamento/montaform");?>',
                data: {idPagamento: idPagamento},
                type: "post",
                dataType: "text"
            }).done(function(retorno){
                $("#divDadosPagamento").empty();
                $("#divDadosPagamento").append(retorno);
            });

            $("#modalPagarConta").dialog("open");
        });
        $('#buscarPagamentosAluno').click(function(event){
            event.preventDefault();
            var idAluno = $('#idAluno').val();
            if(idAluno > 0)
            {
                $.ajax({
                    url: '<?php echo $this->createUrl('pagamento/emaberto');?>',
                    data: {idAluno: idAluno},
                    type: 'post',
                    dataType: 'json'
                }).done(function(JSON){
                    if(JSON.MSG){
                        alert(JSON.MSG);
                    }

                    if(JSON.PAGAMENTOS.length > 0)
                    {
                        $('#tbodyTurma > tr').remove();
                        for(var i=0; i<JSON.PAGAMENTOS.length;  i++)
                        {
                            var linha = $('<tr id="linha_pgto_'+JSON.PAGAMENTOS[i].idPagamento+'">');
                            $(linha).append('<td>'+JSON.PAGAMENTOS[i].turma+'</td>');
                            $(linha).append('<td>'+JSON.PAGAMENTOS[i].dataVencimento+'</td>');
                            $(linha).append('<td style="text-align: right;">'+JSON.PAGAMENTOS[i].valorPagar+'</td>');
                            $(linha).append('<td rel="tooltip" title="Registrar Pagamento"><a class="pagarTurma" href="'+JSON.PAGAMENTOS[i].url+'" data-idPagamento="'+JSON.PAGAMENTOS[i].idPagamento+'" ><i class="icon-money"></i> </td>');
                            $(linha).append('<td rel="tooltip" title="Cancelar Pagamento"><a class="cancelarPagamento" href="'+JSON.PAGAMENTOS[i].urlCancelar+'" data-idPagamento="'+JSON.PAGAMENTOS[i].idPagamento+'" ><i class="icon-ban-circle"></i> </td>');
                            $('#tbodyTurma').append(linha);
                        }
                        $('#divTurmas').show();
                    }
                });
            }
            else
            {
                alert('Favor Selecionar um Aluno.');
            }
        });
    })
</script>
