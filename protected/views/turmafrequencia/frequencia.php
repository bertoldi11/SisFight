<?php
$this->breadcrumbs=array(
    'Frequencia',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>
            <?php echo $cabecalho->idTurma0->idModalidade0->descricao .' - '.substr($cabecalho->idTurma0->inicio,0,5).' as '.substr($cabecalho->idTurma0->termino,0,5);?>
            (<?php echo Formatacao::formatData($cabecalho->data);?>)
        </legend>
        <div class="clearfix">
            <div class="span9">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'id'=>'busca-aluno-form',
                    'enableAjaxValidation'=>false,
                ));
                ?>
                <label for="aluno">Aluno</label>
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                    'name'=>'aluno',
                    'sourceUrl'=>$this->createUrl('/aluno/buscar', array('idModalidade'=>$cabecalho->idTurma0->idModalidade0->idModalidade)),
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
                <button class="btn btn-primary" id="adicionarAlunoFrequencia">+</button>
                <input type="hidden" name="idAluno" id="idAluno" />
                <?php $this->endWidget(); ?>
            </div>
            <div class="span4" id="divAlunos" style="margin-left: 0">
                <?php $box = $this->beginWidget(
                    'bootstrap.widgets.TbBox',
                    array(
                        'title' => 'Dia: '.Formatacao::formatData($cabecalho->data),
                        'headerIcon' => 'icon-th-list',
                        'htmlOptions' => array('class' => 'bootstrap-widget-table')
                    )
                );?>
                <table>
                    <thead>
                    <tr>
                        <th colspan="2">Aluno</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyAluno">
                    <?php if(count($alunos) > 0):?>
                        <?php foreach($alunos as $aluno):?>
                            <tr>
                                <td><?php echo $aluno->nome;?></td>
                                <td><a class="excluirAluno" href="?idAluno=<?php echo $aluno->idAluno;?>&idTurmaFrequencia=<?php echo $cabecalho->idTurmaFrequencia;?>" ><i class="icon-trash"></i></a></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    </tbody>
                </table>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="clearfix">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'aluno-form',
                'enableAjaxValidation'=>false,
                'action'=>$this->createUrl('turmafrequencia/fechar',array('id'=>$cabecalho->idTurmaFrequencia))
            )); ?>
                <div class="form-actions span5">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type'=>'primary',
                        'label'=>'Fechar',
                    )); ?>
                </div>
            <?php $this->endWidget(); ?>
        </div>
    </fieldset>
</div>
<script>
$(function(){
    $('a.excluirAluno').live('click', function(event){
        event.preventDefault();
        var link = $(this);

        if(confirm('Deseja excluir esse aluno da presença?'))
        {
            var query = $(this).attr('href');
            $.ajax({
                url: '<?php echo $this->createUrl('turmafrequencia/excluirAluno');?>'+query,
                type: 'get',
                dataType: 'json',
            }).done(function(JSON){
                    if(JSON.MSG){
                        alert(JSON.MSG);
                    }

                    if(JSON.CONTINUAR){
                        $(link).parent().parent().remove();
                    }
                });
        }
    });

    $('#adicionarAlunoFrequencia').click(function(event){
        event.preventDefault();
        var idAluno = $('#idAluno').val();
        var nomeAluno = $('#aluno').val();
        var idTurmaFrequencia = '<?php echo $cabecalho->idTurmaFrequencia;?>';
        if(idAluno > 0)
        {
            $.ajax({
                url: '<?php echo $this->createUrl('turmafrequencia/adicionarAluno');?>',
                type: 'post',
                dataType: 'json',
                data:{idAluno: idAluno, idTurmaFrequencia: idTurmaFrequencia}
            }).done(function(JSON){
                if(JSON.MSG){
                    alert(JSON.MSG);
                }

                if(JSON.CONTINUAR){
                    var url = '?idAluno='+idAluno+'&idTurmaFrequencia='+idTurmaFrequencia;
                    var linha = $('<tr>');
                    $(linha).append('<td>'+nomeAluno+'</td>');
                    $(linha).append('<td><a class="excluirAluno" href="'+url+'" ><i class="icon-trash"></i></a></td>');

                    $('#tbodyAluno').append(linha);
                    $('#idAluno').val('');
                    $('#aluno').val('');
                }
            });
        }
        else
        {
            alert('Selecione um Aluno.');
        }
    });
});
</script>