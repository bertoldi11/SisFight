<?php

class AlunoController extends Controller
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
                'actions'=>array('novo','alterar','delete','index','buscar'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionBuscar()
    {
        $retorno = array();
        $criteria = new CDbCriteria;
        $criteria->compare('nome',$_GET['term'],true);

        $alunos = Aluno::model()->findAll($criteria);
        foreach($alunos as $aluno)
        {
            $retorno[] = array(
                'id'=>$aluno->idAluno,
                'label'=>$aluno->nome
            );
        }

        echo CJSON::encode($retorno);
        Yii::app()->end();
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionNovo()
    {
        $model=new Aluno;

        if(isset($_POST['Aluno']))
        {
            $model->attributes=$_POST['Aluno'];
            $model->idUsuario = Yii::app()->user->idUsuario;

            if ($model -> save())
            {
                Yii::app()->user->setFlash('success', 'Dados Salvos.');
                $this->redirect($this->createUrl('aluno/alterar', array('id'=>$model->idAluno)));
            }
            else
            {
                $this->_model = $model;
                $this->actionIndex();
                exit;
            }
        }
        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('maskedinput');

        $this->render('dadosaluno', array(
           'model'=>$model,
           'abaAtiva'=>0
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionAlterar($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['Aluno']))
        {
            $model->attributes=$_POST['Aluno'];
            if(isset($_POST['Aluno']['idEndereco']))
            {
                Yii::app()->user->setFlash('abaAtiva', 2);
                $model->salvandoEndereco = true;
            }

            if ($model -> save())
            {
                Yii::app()->user->setFlash('success', 'Dados Alterados.');
            }
        }

        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('maskedinput');

        if(isset( Yii::app()->session['alunoContato']))
        {
            $modelContato =  Yii::app()->session['alunoContato'];
            unset(Yii::app()->session['alunoContato']);
        }
        else
            $modelContato = new Alunocontato;

        if(isset( Yii::app()->session['alunoTurma']))
        {
            $modelTurma =  Yii::app()->session['alunoTurma'];
            unset(Yii::app()->session['alunoTurma']);
        }
        else
            $modelTurma = new Alunoturma;

        $dataProviderContatos = new CActiveDataProvider('Alunocontato', array(
            'criteria'=>array(
                'condition'=>'idAluno = :idAluno',
                'params'=>array(':idAluno'=>$model->idAluno)
            ),
        ));

        $dataProviderTurma = new CActiveDataProvider('Alunoturma', array(
            'criteria'=>array(
                'condition'=>'idAluno = :idAluno',
                'params'=>array(':idAluno'=>$model->idAluno),
                'with'=>array('idTipoAluno0','idTurma0','idTurma0.idModalidade0')
            ),
        ));

        $modelEndereco = (!is_null($model->idEndereco) && !empty($model->idEndereco)) ? Endereco::model()->with('idCidade0','idCidade0.idUf0')->findByPk($model->idEndereco)
                                                                                                    : null;

        if(Yii::app()->params['tipoCobranca'] == 1)
        {
            $modelDescTurma  =CHtml::listData(Turma::model()->with('idModalidade0')->findAll('t.status = "A"'),'idTurma',
                function($turma){
                    return CHtml::encode($turma->idModalidade0->descricao.' - '.substr($turma->inicio,0,5).' as '.substr($turma->termino,0,5));
                }
            );
        }
        elseif(Yii::app()->params['tipoCobranca'] == 2)
        {
            $modelDescTurma  =CHtml::listData(Modalidade::model()->findAll('status = "A"'),'idModalidade','descricao');
        }


        $abaAtiva = Yii::app()->user->getFlash('abaAtiva');
        $abaAtiva = ($abaAtiva >=0) ? $abaAtiva : 0;

        $model->dtNasc = Formatacao::formatData($model->dtNasc);

        $this->render('dadosaluno', array(
            'model'=>$model,
            'modelContato'=>$modelContato,
            'modelTurma'=>$modelTurma,
            'abaAtiva'=>$abaAtiva,
            'dataProviderContatos'=>$dataProviderContatos,
            'dataProviderTurma'=>$dataProviderTurma,
            'modelTiposAluno'=>CHtml::listData(Tipoaluno::model()->findAll(),'idTipoAluno','descricao'),
            'modelDescTurma'=>$modelDescTurma,
            'modelEndereco'=>$modelEndereco
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
        $model=new Aluno('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['Aluno']))
            $model->attributes=$_GET['Aluno'];

        $criteria=new CDbCriteria();
        $count=Usuario::model()->count();
        $pages=new CPagination($count);

        // results per page
        $pages->pageSize=1;
        $pages->applyLimit($criteria);


        $this->render('index',array(
            'model'=>$model,
            'pages'=>$pages
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Aluno::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='aluno-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}