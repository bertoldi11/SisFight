<?php

/**
 * This is the model class for table "turmafrequencia".
 *
 * The followings are the available columns in table 'turmafrequencia':
 * @property integer $idTurmaFrequencia
 * @property integer $idTurma
 * @property string $data
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Aluno[] $alunos
 * @property Turma $idTurma0
 */
class Turmafrequencia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'turmafrequencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idTurma, data', 'required'),
			array('idTurma', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idTurmaFrequencia, idTurma, data, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'alunos' => array(self::MANY_MANY, 'Aluno', 'alunofrequencia(idTurmaFrequencia, idAluno)'),
			'idTurma0' => array(self::BELONGS_TO, 'Turma', 'idTurma'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idTurmaFrequencia' => 'Id Turma Frequencia',
			'idTurma' => 'Turma',
			'data' => 'Data',
			'status' => 'Status',
		);
	}

    protected function beforeSave()
    {
        parent::beforeSave();
        if($this->scenario == 'insert')
            $this->data = Formatacao::formatData($this->data,'/','-');
        return true;
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idTurmaFrequencia',$this->idTurmaFrequencia);
		$criteria->compare('idTurma',$this->idTurma);
        $criteria->compare('data',$this->data,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Turmafrequencia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
