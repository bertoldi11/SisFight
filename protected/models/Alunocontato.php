<?php

/**
 * This is the model class for table "alunocontato".
 *
 * The followings are the available columns in table 'alunocontato':
 * @property integer $idAlunoContato
 * @property integer $idTipoContato
 * @property integer $idAluno
 * @property string $contato
 * @property string $complemento
 * @property string $default
 *
 * The followings are the available model relations:
 * @property Aluno $idAluno0
 * @property Tipocontato $idTipoContato0
 */
class Alunocontato extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alunocontato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idTipoContato, idAluno', 'required'),
			array('idTipoContato, idAluno', 'numerical', 'integerOnly'=>true),
			array('contato', 'length', 'max'=>30),
			array('complemento', 'length', 'max'=>60),
			array('default', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idAlunoContato, idTipoContato, idAluno, contato, complemento, default', 'safe', 'on'=>'search'),
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
			'idAluno0' => array(self::BELONGS_TO, 'Aluno', 'idAluno'),
			'idTipoContato0' => array(self::BELONGS_TO, 'Tipocontato', 'idTipoContato'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idAlunoContato' => 'Id Aluno Contato',
			'idTipoContato' => 'Tipo',
			'idAluno' => 'Id Aluno',
			'contato' => 'Contato',
			'complemento' => 'Complemento',
			'default' => 'Default',
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

		$criteria->compare('idAlunoContato',$this->idAlunoContato);
		$criteria->compare('idTipoContato',$this->idTipoContato);
		$criteria->compare('idAluno',$this->idAluno);
		$criteria->compare('contato',$this->contato,true);
		$criteria->compare('complemento',$this->complemento,true);
		$criteria->compare('default',$this->default,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alunocontato the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
