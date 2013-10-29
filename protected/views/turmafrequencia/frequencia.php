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
        <div class="span8">
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
        <div class="span4" id="divAlunos">
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
                                <td><a class="excluirAluno" href="#" ><i class="icon-trash"></i></a></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
            <?php $this->endWidget(); ?>
        </div>

    </fieldset>
</div>
<script>
    $(function(){
       $('#adicionarAlunoFrequencia').click(function(event){
            event.preventDefault();
           var idAluno = $('#idAluno').val();
           var nomeAluno = $('#aluno').val();
           if(idAluno > 0)
           {
               $.ajax({
                   url: '<?php echo $this->createUrl('turmafrequencia/adicionarAluno');?>',
                   type: 'post',
                   dataType: 'json',
                   data:{idAluno: idAluno, idTurmaFrequencia: '<?php echo $cabecalho->idTurmaFrequencia;?>'}
               }).done(function(JSON){
                    if(JSON.MSG){
                        alert(JSON>MSG);
                    }

                    if(JSON.CONTINUAR){
                        var linha = $('<tr>');
                        $(linha).append('<td>'+nomeAluno+'</td>');
                        $(linha).append('<td><a class="excluirAluno" href="#" ><i class="icon-trash"></i></a></td>');

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