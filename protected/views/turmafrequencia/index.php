<?php
$this->breadcrumbs=array(
	'Turma Frequencias',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Frequencia</legend>
        <?php $this->widget('bootstrap.widgets.TbButton',
            array(
                'label' => 'Abrir caléndario',
                'type' => 'primary',
                'url'=>$this->createUrl('turmafrequencia/novo'),
            )
        ); ?>
        <hr>
        <?php $this->widget('bootstrap.widgets.TbGridView', array(
            'type'=>'striped bordered condensed',
            'template'=>"{items}",
            'dataProvider'=>$dataProvider,
            'columns'=>array(
                array('name'=> 'idTurmaFrequencia', 'header'=>'Código'),
                array(
                    'name'=> 'idTurma0.idModalidade0.descricao',
                    'header'=>'Turma',
                    'value'=>'$data->idTurma0->idModalidade0->descricao." - ".substr($data->idTurma0->inicio,0,5)." às ".substr($data->idTurma0->termino,0,5)',
                ),
                array('name'=> 'mes', 'header'=>'Mês'),
                array('name'=> 'ano', 'header'=>'Ano'),
                array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A") ? "Aberto" : "Fechado"'),
                array(
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{lancar}',
                    'buttons'=>array(
                        'lancar' => array(
                            'label'=>'Lançar presença',
                            'url'=>'Yii::app()->createUrl("turmafrequencia/alterar", array("id"=>"$data->idTurmaFrequencia"))',
                            'icon'=>'calendar',
                            'visible'=>'true',
                        )
                    )
                )
            ),
        ));?>
    </fieldset>
</div>
