<?php

class AlunocontatoController extends Controller
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
    public function actionNovo($id)
    {
        $model=new Alunocontato;

        if(isset($_POST['Alunocontato']))
        {
            $model->attributes=$_POST['Alunocontato'];
            $model->idAluno = $id;
            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Dados Salvos.');
                unset(Yii::app()->session['alunoContato']);
            }
            else
            {
              Yii::app()->session['alunoContato'] = $model;
            }
        }
        Yii::app()->user->setFlash('abaAtiva', 1);
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
        Yii::app()->session['alunoContato']=$model;

        if(isset($_POST['Alunocontato']))
        {
            $model->attributes=$_POST['Alunocontato'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Dados Alterados.');
                unset(Yii::app()->session['alunoContato']);
            }
        }


        Yii::app()->user->setFlash('abaAtiva', 1);
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
        $dataProvider=new CActiveDataProvider('Alunocontato');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Alunocontato('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Alunocontato']))
            $model->attributes=$_GET['Alunocontato'];

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
        $model=Alunocontato::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='alunocontato-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
