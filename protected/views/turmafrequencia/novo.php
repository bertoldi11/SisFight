<?php
$this->breadcrumbs=array(
    'Turma Frequencias'=>'#',
    'Novo'
);
?>
<div class="box-content span11">
    <fieldset>
        <legend>Nova Frequencia</legend>
        <?php echo $this->renderPartial('_form', array('model'=>$model, 'turmas'=>$turmas));?>
    </fieldset>
</div>