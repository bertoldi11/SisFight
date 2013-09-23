<?php
$this->breadcrumbs=array(
	'Usuarios',
);
?>

<div class="box-content span11">
	<fieldset> 
	    <legend>Usuarios</legend>
	    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	    <hr>
		<?php $this->widget('bootstrap.widgets.TbGridView', array(
			'type'=>'striped',
			'template'=>"{items}",
			'dataProvider'=>$dataProvider,
			'columns'=>array(
				array('name'=> 'idUsuario', 'header'=>'Código'),
				array('name'=> 'nome', 'header'=>'Nome'),
				array('name'=> 'email', 'header'=>'E-mail'),
				array('name'=> 'dtNasc', 'header'=>'Nascimento', 'value'=>'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data->dtNasc))'),
				array(
					'htmlOptions' => array('nowrap'=>'nowrap'),
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{update} {delete}',
					'updateButtonUrl'=>'Yii::app()->createUrl("usuario/alterar", array("id"=>"$data->idUsuario"))',
					'deleteButtonUrl'=>'Yii::app()->createUrl("usuario/delete", array("id"=>"$data->idUsuario"))',
				)
			),
		));?>
	</fieldset>
</div>

