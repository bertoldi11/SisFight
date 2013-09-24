<?php
$this->breadcrumbs=array(
    'Alunos',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Alunos</legend>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Novo Aluno',
            'type' => 'primary',
            'buttonType'=>'link',
            'url'=>$this->createUrl('aluno/novo'),
        ));?>
        <?php $this->widget('bootstrap.widgets.TbGridView', array(
            'type'=>'striped',
            'template'=>"{items}",
            'dataProvider'=>$dataProvider,
            'columns'=>array(
                array('name'=> 'idAluno', 'header'=>'Código'),
                array('name'=> 'nome', 'header'=>'Nome'),
                array(
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{update} {delete}',
                    'updateButtonUrl'=>'Yii::app()->createUrl("aluno/alterar", array("id"=>"$data->idAluno"))',
                    'deleteButtonUrl'=>'Yii::app()->createUrl("aluno/delete", array("id"=>"$data->idAluno"))',
                )
            ),
        ));?>
    </fieldset>
</div>
