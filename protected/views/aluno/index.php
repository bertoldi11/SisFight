<?php
$this->breadcrumbs=array(
    'Alunos',
);



?>
<h1>Alunos</h1>

<?php $this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(
        'Dados Gerais'=> $this->renderPartial('_form', array('model'=>$model), true),
        'Contato'=>$this->renderPartial('application.views.alunocontato._form', array('model'=>$modelContato), true),
    ),
    'options'=>array(
        'collapsible'=>true,
        'active'=>$abaAtiva
    ),
));?>
