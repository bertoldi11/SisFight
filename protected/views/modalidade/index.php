<?php
$this->breadcrumbs=array(
	'Modalidades',
);
?>
<div class="box-content span11">
	<fieldset> 
	    <legend>Modalidades</legend>
	    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	    <hr>
		<?php $this->widget('bootstrap.widgets.TbGridView', array(
			'type'=>'striped',
			'template'=>"{items}",
			'dataProvider'=>$dataProvider,
			'columns'=>array(
				array('name'=> 'idModalidade', 'header'=>'Código'),
				array('name'=> 'descricao', 'header'=>'Descrição'),
				array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A") ? "Ativo" : "Inativo"'),
				array(
					'htmlOptions' => array('nowrap'=>'nowrap'),
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{update} {delete}',
					'updateButtonUrl'=>'Yii::app()->createUrl("modalidade/alterar", array("id"=>"$data->idModalidade"))',
					'deleteButtonUrl'=>'Yii::app()->createUrl("modalidade/delete", array("id"=>"$data->idModalidade"))',
				)
			),
		));?>
	</fieldset>
</div>
