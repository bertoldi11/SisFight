<?php
$tabs = array('Dados Gerais'=> $this->renderPartial('_form', array('model'=>$model), true));
if(!$model->isNewRecord)
{
    $tabs['Contato'] = $this->renderPartial('application.views.alunocontato._form', array(
            'model'=>$modelContato,
            'idAluno'=>$model->idAluno,
            'dataProviderContatos'=>$dataProviderContatos
        ),
        true
    );
    $tabs['Endereco'] = $this->renderPartial('_formendereco', array(
            'modelAluno'=>$model,
            'modelEndereco'=>$modelEndereco
        ),
        true
    );
    $tabs['Modalidade'] = $this->renderPartial('application.views.alunoturma._form', array(
            'model'=>$modelTurma,
            'idAluno'=>$model->idAluno,
            'dataProviderTurma'=>$dataProviderTurma,
            'modelTiposAluno'=>$modelTiposAluno,
            'modelDescTurma'=>$modelDescTurma
        ),
        true
    );
}


$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
        'active'=>$abaAtiva
    ),
));?>