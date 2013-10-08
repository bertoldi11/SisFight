<?php

/**
 * This is the model class for table "turmafrequencia".
 *
 * The followings are the available columns in table 'turmafrequencia':
 * @property integer $idTurmaFrequencia
 * @property integer $idTurma
 * @property integer $mes
 * @property integer $ano
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Alunofrequencia[] $alunofrequencias
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
			array('idTurma, mes, ano', 'required'),
			array('idTurma, mes, ano', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idTurmaFrequencia, idTurma, mes, ano, status', 'safe', 'on'=>'search'),
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
			'alunofrequencias' => array(self::HAS_MANY, 'Alunofrequencia', 'idTurmaFrequencia'),
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
			'mes' => 'Mês',
			'ano' => 'Ano',
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

		$criteria->compare('idTurmaFrequencia',$this->idTurmaFrequencia);
		$criteria->compare('idTurma',$this->idTurma);
		$criteria->compare('mes',$this->mes);
		$criteria->compare('ano',$this->ano);
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
