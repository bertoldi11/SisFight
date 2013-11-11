<?php
$this->breadcrumbs=array(
	'Formas de Pagamento',
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Formas de Pagamento</legend>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        <hr>
        <?php $this->widget('bootstrap.widgets.TbGridView', array(
            'type'=>'striped bordered condensed',
            'template'=>"{items}",
            'dataProvider'=>$dataProvider,
            'columns'=>array(
                array('name'=> 'idFormaPgto', 'header'=>'Código'),
                array('name'=> 'descricao', 'header'=>'Descrição'),
                array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A") ? "Ativo" : "Inativo"'),
                array(
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{update} {delete}',
                    'updateButtonUrl'=>'Yii::app()->createUrl("formapgto/alterar", array("id"=>"$data->idFormaPgto"))',
                    'deleteButtonUrl'=>'Yii::app()->createUrl("formapgto/delete", array("id"=>"$data->idFormaPgto"))',
                )
            ),
        ));?>
    </fieldset>
</div>
