<?php
$this->breadcrumbs=array(
    'Frequencia',
);
?>
<style>
    label{
        display: inline;
    }
</style>
<div class="box-content span11">
    <fieldset>
        <legend><?php echo $cabecalho->idTurma0->idModalidade0->descricao .' - '.substr($cabecalho->idTurma0->inicio,0,5).' as '.substr($cabecalho->idTurma0->termino,0,5);?></legend>
        <?php $box = $this->beginWidget(
            'bootstrap.widgets.TbBox',
            array(
                'title' => Yii::app()->params['meses'][$cabecalho->mes].'/'.$cabecalho->ano,
                'headerIcon' => 'icon-check',
                'htmlOptions' => array('class' => 'bootstrap-widget-table')
            )
        );?>

        <table class="items table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <?php for($i = 1; $i <= 31; $i++)
                    {
                        $diaSemana = date('N',mktime(0,0,0,$cabecalho->mes,$i,$cabecalho->ano));
                        if($diaSemana >= 1 && $diaSemana<=5)
                        {
                            echo "<th>".$i."</th>";
                        }
                    }?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($alunos as $aluno):?>
                    <tr class="odd">
                        <td><?php echo $aluno->nome;?></td>
                        <?php $posFrequencia = 0;?>
                        <?php for($i = 1; $i <= 31; $i++)
                        {
                            $diaSemana = date('N',mktime(0,0,0,$cabecalho->mes,$i,$cabecalho->ano));
                            if($diaSemana >= 1 && $diaSemana<=5)
                            {
                               if($aluno->alunofrequencias[$posFrequencia]->dia == $i)
                               {
                                   echo "<td>".CHtml::radioButtonList('frequencia['.$aluno->idAluno.']['.$i.']', $aluno->alunofrequencias[$posFrequencia]->status,Yii::app()->params['statusFreqAluno'])."</td>";
                                   $posFrequencia++;
                               }
                               else
                               {
                                   echo " - ";
                               }

                            }
                        }?>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php $this->endWidget(); ?>
        <p style="margin-top: -15px; padding-left: 5px; font-size: 0.8em; color: #666">N = Não informado | P = Presente | A = Ausente</p>
    </fieldset>
</div>