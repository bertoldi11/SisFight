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
        $model=new Aluno;

        if(isset($_POST['Aluno']))
        {
            $model->attributes=$_POST['Aluno'];
            $model->idUsuario = Yii::app()->user->id;
            if ($model -> save())
            {
                Yii::app()->user->setFlash('success', 'Dados Salvos.');
            }
            else
            {
                $this->_model = $model;
                $this->actionIndex();
                exit;
            }
        }
        Yii::app()->user->setFlash('abaAtiva',0);
        $this->redirect($this->createUrl('aluno/index'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['Aluno']))
        {
            $model->attributes=$_POST['Aluno'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->idAluno));
        }

        $this->render('update',array(
            'model'=>$model,
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
        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('maskedinput');

        $abaAtiva = Yii::app()->user->getFlash('abaAtiva');
        $abaAtiva = ($abaAtiva >=0) ? $abaAtiva : 0;
        $model=(is_null($this->_model)) ? new Aluno : $this->_model;
        $modelContato = new Alunocontato;
        $dataProvider=new CActiveDataProvider('Aluno');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'model'=>$model,
            'modelContato'=>$modelContato,
            'abaAtiva'=>$abaAtiva
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