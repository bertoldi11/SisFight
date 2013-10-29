<?php

class TurmafrequenciaController extends Controller
{
    public $_model = null;
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
                'actions'=>array('novo','alterar','delete','index','adicionarAluno'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionAdicionarAluno()
    {
        $dados = array();
        $model = new Alunofrequencia;
        $model->attributes = array(
            'idTurmaFrequencia'=>$_POST['idTurmaFrequencia'],
            'idAluno'=>$_POST['idAluno']
        );

        if($model->save())
        {
            $dados['CONTINUAR'] = true;
        }
        else
        {
            $dados['CONTINUAR'] = false;
            $dados['MSG'] = 'Erro ao adicionar aluno.';
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
        $model=new Turmafrequencia;

        if(isset($_POST['Turmafrequencia']))
        {
            $model->attributes = $_POST['Turmafrequencia'];

            if($model->save())
            {
                $this->redirect($this->createUrl('turmafrequencia/alterar', array('id'=>$model->idTurmaFrequencia)));
            }
            else
            {
                $this->_model = $model;
            }
        }

        $this->redirect($this->createUrl('turmafrequencia/index'));

    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionAlterar($id)
    {
        $criteriaCabecalho = new CDbCriteria(array(
            'condition'=>'idTurmaFrequencia = :idTurmaFrequencia',
            'params'=>array(':idTurmaFrequencia'=>$id),
            'with'=>array('idTurma0','idTurma0.idModalidade0')
        ));

        $criteriaAlunos = new CDbCriteria(array(
            'with'=>array('turmafrequencias'=>array(
                'condition'=>'turmafrequencias.idTurmaFrequencia = :idTurmaFrequencia',
                'params'=>array(':idTurmaFrequencia'=>$id)
            )),
        ));

        $alunos = Aluno::model()->findAll($criteriaAlunos);
        $cabecalho = Turmafrequencia::model()->find($criteriaCabecalho);

        $this->render('frequencia', array(
            'cabecalho'=>$cabecalho,
            'alunos'=>$alunos
        ));
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
        $dataProvider=new CActiveDataProvider('Turmafrequencia', array(
            'criteria'=>array(
                'with'=>array('idTurma0','idTurma0.idModalidade0')
            ),
        ));

        $turmas = CHtml::listData(Turma::model()->findAll(),'idTurma', function($turma){
            return CHtml::encode($turma->idModalidade0->descricao.' - '.substr($turma->inicio,0,5).' às '.substr($turma->termino,0,5));
        });

        $model=(is_null($this->_model)) ? new Turmafrequencia : $this->_model;
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'model'=>$model,
            'turmas'=>$turmas
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Turmafrequencia('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Turmafrequencia']))
            $model->attributes=$_GET['Turmafrequencia'];

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
        $model=Turmafrequencia::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='turmafrequencia-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
