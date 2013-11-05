<?php

class PagamentoController extends Controller
{
    // Caso esteja sendo feito um update, salva o modulo aqui para poder ler na action index que monta a view.
    private $_model=null;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('novo','alterar','delete','index', 'emAberto','consulta'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionConsulta()
    {
        $dados = array('model'=> new ConsultaPagamentoForm);

        if(isset($_POST['ConsultaPagamentoForm']))
        {
            $criteria = new CDbCriteria(array(
                'with'=>array('idAlunoTurma0','idAlunoTurma0.idAluno0'),
            ));

            if(isset($_POST['ConsultaPagamentoForm']['idAluno']) && $_POST['ConsultaPagamentoForm']['idAluno'] > 0)
            {
                $criteria->compare('idAlunoTurma0.idAluno',$_POST['ConsultaPagamentoForm']['idAluno']);
            }

            if(isset($_POST['ConsultaPagamentoForm']['dataInicio']) && !empty($_POST['ConsultaPagamentoForm']['dataInicio']))
            {
                $criteria->compare('dtVencimento','>='.Formatacao::formatData($_POST['ConsultaPagamentoForm']['dataInicio'],'/','-'));
            }

            if(isset($_POST['ConsultaPagamentoForm']['dataFim']) && !empty($_POST['ConsultaPagamentoForm']['dataFim']))
            {
                $criteria->compare('dtVencimento','<='.Formatacao::formatData($_POST['ConsultaPagamentoForm']['dataFim'],'/','-'));
            }

            if(isset($_POST['ConsultaPagamentoForm']['status']) && !empty($_POST['ConsultaPagamentoForm']['status']))
            {
                $criteria->addInCondition('t.status',$_POST['ConsultaPagamentoForm']['status']);
            }

            $dataProviderPagamentos = new CActiveDataProvider('Pagamento',array('criteria'=>$criteria,'pagination'=>false));

            $dados['dataProviderPagamentos'] = $dataProviderPagamentos;
        }

        $this->render('consulta',$dados);
    }

    private  function montaNomeTurma($model)
    {
        return $model->idAlunoTurma0->idTurma0->idModalidade0->descricao. ' - ' . substr($model->idAlunoTurma0->idTurma0->inicio,0,5). ' as '.substr($model->idAlunoTurma0->idTurma0->termino,0,5);
    }

    public function actionEmAberto()
    {
        $dados = array();
        $criteria = new CDbCriteria(array(
            'condition'=>'t.status = "A"',
        ));

        if(Yii::app()->params['tipoCobranca'] == 1)
        {
            $criteria->with = array(
                'idAlunoTurma0'=>array('condition'=>'idAluno = :idAluno', 'params'=>array(':idAluno'=>$_POST['idAluno'])),
                'idAlunoTurma0.idTurma0',
                'idAlunoTurma0.idTurma0.idModalidade0'
            );
        }
        else
        {
            $criteria->with = array(
                'idAlunoTurma0'=>array('condition'=>'idAluno = :idAluno', 'params'=>array(':idAluno'=>$_POST['idAluno'])),
                'idAlunoTurma0.idModalidade0'
            );
        }

        $modelPagamentos = Pagamento::model()->findAll($criteria);
        $dados['PAGAMENTOS'] = array();
        if(count($modelPagamentos) > 0)
        {
            foreach($modelPagamentos as $pagamento)
            {
                $dados['PAGAMENTOS'][] = array(
                    'idPagamento'=>$pagamento->idPagamento,
                    'dataVencimento'=>Formatacao::formatData($pagamento->dtVencimento),
                    'valorPagar'=>number_format($pagamento->valorPagar,2,",","."),
                    'turma'=>(Yii::app()->params['tipoCobranca'] == 1) ? $this->montaNomeTurma($pagamento) : $pagamento->idAlunoTurma0->idModalidade0->descricao,
                    'url'=>$this->createUrl('pagamento/alterar', array('id'=>$pagamento->idPagamento)),
                );
            }

        }
        else
        {
            $dados['MSG'] = 'Nenhum Pagamento em aberto para esse aluno.';
        }

        echo CJSON::encode($dados);

        Yii::app()->end();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionNovo()
    {
        $model=new Pagamento;

        if(isset($_POST['Pagamento']))
        {
            $model->attributes=$_POST['Pagamento'];
            if ($model -> save())
            {
                Yii::app()->user->setFlash('success', 'Pagamento Registrado.');
            }
            else
            {
                $this->_model = $model;
                $this->actionIndex();
                exit;
            }
        }

		$this->redirect($this->createUrl('pagamento/index'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionAlterar($id)
    {
        $dados = array('SUCESSO'=>true);
        if(isset($_POST['idPagamento']) && $_POST['idPagamento'] == $id)
        {
            $valorPgto = str_replace(',','.', str_replace('.','',$_POST['valor']));

            if(is_numeric($valorPgto) && $valorPgto > 0)
            {
                $model=$this->loadModel($id);

                $model->attributes = array(
                    'valorPago'=>$valorPgto,
                    'dtPagamento'=>new CDbExpression('NOW()'),
                    'status'=>'P'
                );
                if ($model -> save())
                {
                    $dados['MSG'] = "Pagamento efetuado.";

                    $criteriaAlunoTurma = new CDbCriteria(array(
                        'condition'=>'idAlunoTurma = :idAlunoTurma',
                        'params'=>array(':idAlunoTurma'=>$model->idAlunoTurma),
                        'with'=>array('idTipoAluno0'=>array('select'=>'quantParcelas'))
                    ));
                    $modelAlunoTurma = Alunoturma::model()->find($criteriaAlunoTurma);

                    if($modelAlunoTurma->idTipoAluno0->quantParcelas == 1)
                    {
                        $modelPagamento = new Pagamento;
                        $modelPagamento->attributes = array(
                            'idAlunoTurma'=>$model->idAlunoTurma,
                            'idUsuario'=>Yii::app()->user->idUsuario,
                            'valorPagar'=>$model->valorPagar,
                            'dtCadastro'=> new CDbExpression('NOW()'),
                            'dtVencimento'=>new CDbExpression('DATE_ADD("'.$model->dtVencimento.'",INTERVAL 1 MONTH)'),
                        );

                        $modelPagamento->save();
                    }
                    else
                    {
                        $criteriaParcAberta = new CDbCriteria(array(
                            'condition'=>'idAlunoTurma = :idAlunoTurma AND status = "A"',
                            'params'=>array(':idAlunoTurma'=>$model->idAlunoTurma)
                        ));

                        $quantPgAberto = Pagamento::model()->count($criteriaParcAberta);
                        if($quantPgAberto == 0)
                        {
                            $dados['ULTIMO_PGTO'] = true;
                            $dados['URL']= $this->createUrl('alunoturma/renovar', array('id'=>$model->idAlunoTurma));
                        }
                    }
                }
            }
            else
            {
                $dados['MSG'] = "Dados inválidos.";
                $dados['SUCESSO'] = false;
            }
        }
        else
        {
            $dados['MSG'] = "Dados inválidos.";
            $dados['SUCESSO'] = false;
        }
        echo CJSON::encode($dados);
        Yii::app()->end();
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = (is_null($this->_model)) ? new Pagamento : $this->_model;
        $dataProvider=new CActiveDataProvider('Pagamento');
        $this -> render('index', array(
            'model'=>$model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Pagamento('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Pagamento']))
            $model->attributes=$_GET['Pagamento'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Pagamento::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='pagamento-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
