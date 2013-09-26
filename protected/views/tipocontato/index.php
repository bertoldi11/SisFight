<?php
$this->breadcrumbs=array(
	'Tipocontatos',
);

?>

<div class="box-content span11">
	<fieldset> 
	    <legend>Tipos de Contato</legend>
	    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	    <hr>
		<?php $this->widget('bootstrap.widgets.TbGridView', array(
			'type'=>'striped bordered condensed',
			'template'=>"{items}",
			'dataProvider'=>$dataProvider,
			'columns'=>array(
				array('name'=> 'idTipoContato', 'header'=>'Código'),
				array('name'=> 'descricao', 'header'=>'Descrição'),
				array('name'=> 'prefixo', 'header'=>'Prefixo'),
				array('name'=> 'mascara', 'header'=>'Máscara'),
				array('name'=> 'classe', 'header'=>'Classe'),
				array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A") ? "Ativo" : "Inativo"'),
				array(
					'htmlOptions' => array('nowrap'=>'nowrap'),
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{update} {delete}',
					'updateButtonUrl'=>'Yii::app()->createUrl("modalidade/alterar", array("id"=>"$data->idTipoContato"))',
					'deleteButtonUrl'=>'Yii::app()->createUrl("modalidade/delete", array("id"=>"$data->idTipoContato"))',
				)
			),
		));?>
	</fieldset>
</div>
