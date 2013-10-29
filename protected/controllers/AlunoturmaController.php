<?php

class AlunoturmaController extends Controller
{
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
                'actions'=>array('novo','alterar','delete','index','buscarporaluno','renovar'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionNovo($id)
    {
        $model=new Alunoturma;

        if(isset($_POST['Alunoturma']))
        {
            $_POST['Alunoturma']['valor'] = str_replace(',','.', str_replace('.','',$_POST['Alunoturma']['valor']));
            $model->attributes=$_POST['Alunoturma'];
            $model->idAluno = $id;
            if($model->save())
            {
               $criteriaTipoAluno = new CDbCriteria(array(
                   'select'=>'geraPagamento, quantParcelas',
                   'condition'=>'idTipoAluno = :idTipoAluno',
                   'params'=>array(':idTipoAluno'=>$model->idTipoAluno)
               ));

                $modelTipoAluno = Tipoaluno::model()->find($criteriaTipoAluno);

                if($modelTipoAluno->geraPagamento == 'S')
                {
                    if($modelTipoAluno->quantParcelas > 0 )
                    {
                        for($i=0;$i < $modelTipoAluno->quantParcelas; $i++)
                        {
                            $vencimento = ($i==0) ? $model->dtPrimeiroPgto : new CDbExpression("DATE_ADD(NOW(), INTERVAL ".$i. " MONTH)");
                            $novoPagamento = new Pagamento;
                            $novoPagamento->attributes = array(
                                'idAlunoTurma'=>$model->idAlunoTurma,
                                'valorPagar'=>$model->valor,
                                'dtCadastro'=>new CDbExpression('NOW()'),
                                'dtVencimento'=>$vencimento,
                                'idUsuario'=>Yii::app()->user->idUsuario
                            );
                            $novoPagamento->save();
                        }
                    }
                }


                Yii::app()->user->setFlash('success', 'Dados Salvos.');
                unset(Yii::app()->session['alunoTurma']);
            }
            else
            {
                Yii::app()->session['alunoTurma'] = $model;
            }
        }
        Yii::app()->user->setFlash('abaAtiva', 3);
        $this->redirect($this->createUrl('aluno/alterar', array('id'=>$id)));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionAlterar($id)
    {
        $model=$this->loadModel($id);
        Yii::app()->session['alunoTurma']=$model;

        if(isset($_POST['Alunoturma']))
        {
            if($model->status != $_POST['Alunoturma']['status'])
            {
               //TODO: Ações ao inativar/reativar usuário
            }

            if($model->idAlunoTurma != $_POST['Alunoturma']['idAlunoTurma'])
            {
                //TODO: Ações ao mudar tipo de aluno.
            }
            $model->attributes=$_POST['Alunoturma'];


            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Dados Alterados.');
                unset(Yii::app()->session['alunoTurma']);
            }
        }


        Yii::app()->user->setFlash('abaAtiva', 3);
        $this->redirect($this->createUrl('aluno/alterar', array('id'=>$id)));
    }

    public function actionRenovar($id)
    {
        $this->render('renovar');
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
        $dataProvider=new CActiveDataProvider('Alunoturma');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Alunoturma::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='alunoturma-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}