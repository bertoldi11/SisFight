<?php

class EnderecoController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters() {
        return array('accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('buscarCep'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    private function _tranformaJSON($model)
    {
        $enderecos = array();

        foreach($model as $endereco)
        {
            $enderecos[] = array(
                'idEndereco' => $endereco->idEndereco,
                'logradouro' => $endereco->logradouro,
                'bairro' => $endereco->bairro,
                'cidade' => $endereco->idCidade0->nome,
                'uf'=> $endereco->idCidade0->idUf0->sigla
            );
        }

        return $enderecos;
    }

    public function actionBuscarCep()
    {

        $retorno = array();
        $msg = '';

        $cep = preg_replace('/\W/i' , '' , $_POST['CEP']);
        if(strlen($cep) == 8)
        {
            $modelEnderecos = new CActiveDataProvider('Endereco',array(
                'criteria'=>array(
                    'condition'=>'cep=:cep',
                    'params'=>array(':cep'=>$cep),
                    'with'=>array('idCidade0','idCidade0.idUf0'),
                ),
                'pagination'=>false,
            ));

            if(count($modelEnderecos->getData()) == 0){
                $resposta = Yii::app()->buscaPorCep->run($cep);
                if(count($resposta > 0))
                {
                    $cidade = Cidade::model()->findByAttributes(array('nome'=>$resposta['city']));
                    $endereco = new Endereco;
                    $endereco->attributes = array(
                        'idCidade'=>$cidade->idCidade,
                        'logradouro'=>$resposta['location'],
                        'bairro'=>$resposta['district'],
                        'cep'=>$cep
                    );

                    $endereco->save();

                    $enderecos[] = array(
                        'idEndereco' => $endereco->idEndereco,
                        'logradouro' => $endereco->logradouro,
                        'bairro' => $endereco->bairro,
                        'cidade' => $endereco->idCidade0->nome,
                        'uf'=> $endereco->idCidade0->idUf0->sigla
                    );

                }
            }
            else
            {
                $enderecos = $this->_tranformaJSON($modelEnderecos->getData());
            }

        }
        else
        {
            $msg =  'CEP inválido';
            $enderecos = NULL;
        }

        $retorno = array(
            'providerEndereco' => $enderecos,
            'MSG'=>$msg,
        );

        die(json_encode($retorno));
    }

    public function loadModel($id)
    {
        $model = Endereco::model() -> findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}