<?php
class ConsultaPagamentoForm extends CFormModel
{
    public $idAluno;
    public $nomeAluno;
    public $status;
    public $dataInicio;
    public $dataFim;


    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'status'=>'Status',
            'idAluno'=>'Aluno',
            'dataInicio'=>'Início',
            'dataFim'=>'Fim',
            'nomeAliuno'=>'Aluno'
        );
    }

}?>