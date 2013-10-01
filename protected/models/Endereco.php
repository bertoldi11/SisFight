<?php

/**
 * This is the model class for table "endereco".
 *
 * The followings are the available columns in table 'endereco':
 * @property integer $idEndereco
 * @property integer $idCidade
 * @property string $cep
 * @property string $logradouro
 * @property string $bairro
 *
 * The followings are the available model relations:
 * @property Aluno[] $alunos
 * @property Cidade $idCidade0
 */
class Endereco extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'endereco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idCidade, cep, logradouro, bairro', 'required'),
			array('idCidade', 'numerical', 'integerOnly'=>true),
			array('cep', 'length', 'max'=>8),
			array('logradouro', 'length', 'max'=>100),
			array('bairro', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idEndereco, idCidade, cep, logradouro, bairro', 'safe', 'on'=>'search'),
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
			'alunos' => array(self::HAS_MANY, 'Aluno', 'idEndereco'),
			'idCidade0' => array(self::BELONGS_TO, 'Cidade', 'idCidade'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idEndereco' => 'Id Endereco',
			'idCidade' => 'Id Cidade',
			'cep' => 'Cep',
			'logradouro' => 'Logradouro',
			'bairro' => 'Bairro',
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

		$criteria->compare('idEndereco',$this->idEndereco);
		$criteria->compare('idCidade',$this->idCidade);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('logradouro',$this->logradouro,true);
		$criteria->compare('bairro',$this->bairro,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Endereco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
