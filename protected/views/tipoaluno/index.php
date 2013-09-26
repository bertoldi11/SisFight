<?php
$this->breadcrumbs=array(
	'Tipoalunos',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Tipos de Aluno</legend>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        <hr>
        <?php $this->widget('bootstrap.widgets.TbGridView', array(
            'type'=>'striped bordered condensed',
            'template'=>"{items}",
            'dataProvider'=>$dataProvider,
            'columns'=>array(
                array('name'=> 'idTipoAluno', 'header'=>'Código'),
                array('name'=> 'descricao', 'header'=>'Descrição'),
               // array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A") ? "Ativo" : "Inativo"'),
                array(
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{update} {delete}',
                    'updateButtonUrl'=>'Yii::app()->createUrl("tipoaluno/alterar", array("id"=>"$data->idTipoAluno"))',
                    'deleteButtonUrl'=>'Yii::app()->createUrl("tipoaluno/delete", array("id"=>"$data->idTipoAluno"))',
                )
            ),
        ));?>
    </fieldset>
</div>
