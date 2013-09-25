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
                'actions'=>array('novo','alterar','delete','index','buscarporaluno'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionBuscarPorAluno()
    {
        $dados = array();
        $criteria = new CDbCriteria(array(
            'condition'=>'idAluno = :idAluno',
            'params'=>array(':idAluno'=>$_POST['idAluno']),
            'with'=>array('idTurma0','idTurma0.idModalidade0')
        ));

        $turmas = Alunoturma::model()->findAll($criteria);

        if(count($turmas) > 0)
        {
            foreach($turmas as $turma)
            {
                $dados['TURMAS'][]=array(
                    'idAlunoTurma'=>$turma->idAlunoTurma,
                    'turma'=>$turma->idTurma0->idModalidade0->descricao.' - '.substr($turma->idTurma0->inicio,0,5). ' as '.substr($turma->idTurma0->termino,0,5),
                    'valorPagar'=>$turma->valor
                );
            }
        }
        else
        {
            $dados['MSG'] = 'Esse aluno não está em nenhuma turma.';
        }

        echo CJSON::encode($dados);
        Yii::app()->end();
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
            $model->attributes=$_POST['Alunoturma'];
            $model->idAluno = $id;
            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Dados Salvos.');
                unset(Yii::app()->session['alunoTurma']);
            }
            else
            {
                Yii::app()->session['alunoTurma'] = $model;
            }
        }
        Yii::app()->user->setFlash('abaAtiva', 2);
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
            $model->attributes=$_POST['Alunoturma'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Dados Alterados.');
                unset(Yii::app()->session['alunoTurma']);
            }
        }


        Yii::app()->user->setFlash('abaAtiva', 2);
        $this->redirect($this->createUrl('aluno/alterar', array('id'=>$id)));
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