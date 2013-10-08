<?php

class TurmafrequenciaController extends Controller
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
                'actions'=>array('novo','alterar','delete','index'),
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
    public function actionNovo()
    {
        $model=new Turmafrequencia;

        if(isset($_POST['Turmafrequencia']))
        {
            $model->attributes=$_POST['Turmafrequencia'];
            $criteriaVerifica = new CDbCriteria(array(
                'condition'=>'status = "A" AND idTurma = :idTurma',
                'params'=>array(':idTurma'=>$_POST['Turmafrequencia']['idTurma'])
            ));
            if(Turmafrequencia::model()->count($criteriaVerifica) == 0)
            {
                if($model->save())
                {
                    if(Yii::app()->params['tipoCobranca'] == 1)
                    {
                       //Seleciona todos os alunos da turma
                        $criteriaAluno = new CDbCriteria(array(
                            'condition'=>'t.status = "A" AND idTurma = :idTurma',
                            'params'=>array(':idTurma'=>$model->idTurma),
                        ));
                    }
                    else
                    {
                        //Seleciona todos os alunos da modalidade
                        $criteriaModalidade = new CDbCriteria(array(
                            'select'=>'idModalidade',
                            'condition'=>'idTurma = :idTurma',
                            'params'=>array(':idTurma'=>$model->idTurma),
                        ));

                        $modelModalidade = Turma::model()->find($criteriaModalidade);

                        $criteriaAluno = new CDbCriteria(array(
                            'condition'=>'t.status = "A" AND idModalidade = :idModalidade',
                            'params'=>array(':idModalidade'=>$modelModalidade->idModalidade),
                        ));

                        unset($modelModalidade);
                        unset($criteriaModalidade);
                    }
                    $alunos = Alunoturma::model()->findAll($criteriaAluno);
                    if(count($alunos) > 0)
                    {
                        for($i = 1; $i <= 31; $i++)
                        {
                            $diaSemana = date('N',mktime(0,0,0,$model->mes,$i,$model->ano));
                            if($diaSemana >= 1 && $diaSemana<=5)
                            {
                                foreach($alunos as $aluno)
                                {
                                    $modelAlunoFrequencia = new Alunofrequencia;
                                    $modelAlunoFrequencia->attributes = array(
                                        'idTurmaFrequencia'=>$model->idTurmaFrequencia,
                                        'idAluno'=>$aluno->idAluno,
                                        'dia'=>$i,
                                        'status'=>'N'
                                    );
                                    $modelAlunoFrequencia->save();
                                }
                            }
                        }
                    }
                    Yii::app()->user->setFlash('success', 'Turma Criada.');
                    $this->redirect($this->createUrl('turmafrequencia/index'));
                }
            }
            else
            {
                $model->addError('idTurma','Existe uma frequência aberta para essa Turma.');
            }
        }

        $criteriaTurma = new CDbCriteria(array(
            'condition'=>'t.status = "A"',
            'with'=>array('idModalide0')
        ));
        $turmas = CHtml::listData(Turma::model()->findAll(),'idTurma', function($turma){
            return CHtml::encode($turma->idModalidade0->descricao.' - '.substr($turma->inicio,0,5).' às '.substr($turma->termino,0,5));
        });
        $this->render('novo',array(
            'model'=>$model,
            'turmas'=>$turmas
        ));
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
            'with'=>array(
                'alunofrequencias'=>array(
                    'condition'=>'idTurmaFrequencia = :idTurmaFrequencia',
                    'params'=>array(':idTurmaFrequencia'=>$id),
                    'order'=>'dia'
                )
            ),
            'order'=>'nome'
        ));

        $cabecalho = Turmafrequencia::model()->find($criteriaCabecalho);
        $alunos = Aluno::model()->findAll($criteriaAlunos);

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
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
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
