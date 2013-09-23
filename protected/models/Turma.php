<?php

/**
 * This is the model class for table "turma".
 *
 * The followings are the available columns in table 'turma':
 * @property integer $idTurma
 * @property integer $idModalidade
 * @property string $inicio
 * @property string $termino
 * @property integer $capacidade
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Alunoturma[] $alunoturmas
 * @property Modalidade $idModalidade0
 */
class Turma extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'turma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idModalidade, inicio, termino, capacidade', 'required'),
			array('idModalidade, capacidade', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idTurma, idModalidade, inicio, termino, capacidade, status', 'safe', 'on'=>'search'),
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
			'alunoturmas' => array(self::HAS_MANY, 'Alunoturma', 'idTurma'),
			'idModalidade0' => array(self::BELONGS_TO, 'Modalidade', 'idModalidade'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idTurma' => 'Cod. Turma',
			'idModalidade' => 'Modalidade',
			'inicio' => 'Início',
			'termino' => 'Término',
			'capacidade' => 'Capacidade',
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

		$criteria->compare('idTurma',$this->idTurma);
		$criteria->compare('idModalidade',$this->idModalidade);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('termino',$this->termino,true);
		$criteria->compare('capacidade',$this->capacidade);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Turma the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
