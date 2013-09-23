<?php
$this->breadcrumbs=array(
	'Turmas',
);
?>
<div class="box-content span11">
	<fieldset> 
	    <legend>Turmas</legend>
	    <?php echo $this->renderPartial('_form', array('model'=>$model,'dataModalidades'=>$dataModalidades)); ?>
	    <hr>
		<?php $this->widget('bootstrap.widgets.TbGridView', array(
			'type'=>'striped',
			'template'=>"{items}",
			'dataProvider'=>$dataProvider,
			'columns'=>array(
				array('name'=> 'idTurma', 'header'=>'Código'),
				array('name'=> 'idModalidade0.descricao', 'header'=>'Modalidade'),
				array('name'=> 'inicio', 'header'=>'Hora Início'),
				array('name'=> 'termino', 'header'=>'Hora Término'),
				array('name'=> 'capacidade', 'header'=>'Capacidade'),
				array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A") ? "Ativo" : "Inativo"'),
				array(
					'htmlOptions' => array('nowrap'=>'nowrap'),
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{update} {delete}',
					'updateButtonUrl'=>'Yii::app()->createUrl("turma/alterar", array("id"=>"$data->idTurma"))',
					'deleteButtonUrl'=>'Yii::app()->createUrl("turma/delete", array("id"=>"$data->idTurma"))',
				)
			),
		));?>
	</fieldset>
</div>

