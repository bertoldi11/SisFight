<?php
$this->breadcrumbs=array(
	'Bancos',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Bancos</legend>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        <hr>
        <?php $this->widget('bootstrap.widgets.TbGridView', array(
            'type'=>'striped bordered condensed',
            'template'=>"{items}",
            'dataProvider'=>$dataProvider,
            'columns'=>array(
                array('name'=> 'idBanco', 'header'=>'Código'),
                array('name'=> 'codFebraban', 'header'=>'Cod. Febraban'),
                array('name'=> 'nome', 'header'=>'Nome'),
                array(
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{update} {delete}',
                    'updateButtonUrl'=>'Yii::app()->createUrl("banco/alterar", array("id"=>"$data->idBanco"))',
                    'deleteButtonUrl'=>'Yii::app()->createUrl("banco/delete", array("id"=>"$data->idBanco"))',
                )
            ),
        ));?>
    </fieldset>
</div>
