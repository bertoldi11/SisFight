<?php
$this->breadcrumbs=array(
    'Pagamentos',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Pagamento</legend>
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
                <button class="btn btn-primary" id="buscarTurmasAluno"><i class="icon-search"></i></button>
                <input type="hidden" name="idAluno" id="idAluno" />
            <?php $this->endWidget(); ?>
            <div class="span4" style="margin: 0; display: none" id="divTurmas">
                <?php $box = $this->beginWidget(
                    'bootstrap.widgets.TbBox',
                    array(
                        'title' => 'Turmas',
                        'headerIcon' => 'icon-th-list',
                        'htmlOptions' => array('class' => 'bootstrap-widget-table')
                    )
                );?>
                    <table>
                        <thead>
                        <tr>
                            <th>Turma</th>
                            <th>Valor a Pagar</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyTurma">

                        </tbody>
                    </table>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div id="dadosPagamento" style="display: none">
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </fieldset>
</div>
<script>
    $(function(){
        $('#buscarTurmasAluno').click(function(event){
            event.preventDefault();
            var idAluno = $('#idAluno').val();
            if(idAluno > 0)
            {
                $.ajax({
                    url: '<?php echo $this->createUrl('alunoturma/buscarporaluno');?>',
                    data: {idAluno: idAluno},
                    type: 'post',
                    dataType: 'json'
                }).done(function(JSON){
                    if(JSON.MSG){
                        alert(JSON.MSG);
                    }

                    if(JSON.TURMAS.length > 0)
                    {
                        $('#tbodyTurma > tr').remove();
                        for(var i=0; i<JSON.TURMAS.length;  i++)
                        {
                            var linha = $('<tr>');
                            $(linha).append('<td>'+JSON.TURMAS[i].turma+'</td>');
                            $(linha).append('<td>'+JSON.TURMAS[i].valorPagar+'</td>');
                            $(linha).append('<td><a class="pagarTurma" href="/pagamento/novo" data-idAlTu="'+JSON.TURMAS[i].idAlunoTurma+'" ><i class="icon-money"></i> </td>');
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
