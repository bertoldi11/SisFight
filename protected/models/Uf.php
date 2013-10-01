<?php

/**
 * This is the model class for table "uf".
 *
 * The followings are the available columns in table 'uf':
 * @property integer $idUf
 * @property string $nome
 * @property string $sigla
 *
 * The followings are the available model relations:
 * @property Cidade[] $cidades
 */
class Uf extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'uf';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, sigla', 'required'),
			array('nome', 'length', 'max'=>20),
			array('sigla', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idUf, nome, sigla', 'safe', 'on'=>'search'),
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
			'cidades' => array(self::HAS_MANY, 'Cidade', 'idUf'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idUf' => 'Id Uf',
			'nome' => 'Nome',
			'sigla' => 'Sigla',
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

		$criteria->compare('idUf',$this->idUf);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('sigla',$this->sigla,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Uf the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
