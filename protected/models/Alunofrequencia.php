<?php

/**
 * This is the model class for table "alunofrequencia".
 *
 * The followings are the available columns in table 'alunofrequencia':
 * @property integer $idAlunoFrequencia
 * @property integer $idTurmaFrequencia
 * @property integer $idAluno
 * @property integer $dia
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Turmafrequencia $idTurmaFrequencia0
 * @property Aluno $idAluno0
 */
class Alunofrequencia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alunofrequencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idTurmaFrequencia, idAluno, dia', 'required'),
			array('idTurmaFrequencia, idAluno, dia', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idAlunoFrequencia, idTurmaFrequencia, idAluno, dia, status', 'safe', 'on'=>'search'),
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
			'idTurmaFrequencia0' => array(self::BELONGS_TO, 'Turmafrequencia', 'idTurmaFrequencia'),
			'idAluno0' => array(self::BELONGS_TO, 'Aluno', 'idAluno'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idAlunoFrequencia' => 'Id Aluno Frequencia',
			'idTurmaFrequencia' => 'Id Turma Frequencia',
			'idAluno' => 'Id Aluno',
			'dia' => 'Dia',
			'status' => 'Status',
		);
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

		$criteria->compare('idAlunoFrequencia',$this->idAlunoFrequencia);
		$criteria->compare('idTurmaFrequencia',$this->idTurmaFrequencia);
		$criteria->compare('idAluno',$this->idAluno);
		$criteria->compare('dia',$this->dia);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alunofrequencia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
