<?php
$this->breadcrumbs=array(
	'Alunos',
);
?>

<h1>Alunos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
