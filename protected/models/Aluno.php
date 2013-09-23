<?php

/**
 * This is the model class for table "aluno".
 *
 * The followings are the available columns in table 'aluno':
 * @property integer $idAluno
 * @property integer $idUsuario
 * @property string $nome
 * @property string $dtNasc
 * @property string $nomeMae
 * @property string $nomePai
 *
 * The followings are the available model relations:
 * @property Usuario $idUsuario0
 * @property Alunocontato[] $alunocontatos
 * @property Alunoturma[] $alunoturmas
 */
class Aluno extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aluno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idUsuario, nome, dtNasc', 'required'),
			array('idUsuario', 'numerical', 'integerOnly'=>true),
			array('nome, nomeMae, nomePai', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idAluno, idUsuario, nome, dtNasc, nomeMae, nomePai', 'safe', 'on'=>'search'),
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
			'idUsuario0' => array(self::BELONGS_TO, 'Usuario', 'idUsuario'),
			'alunocontatos' => array(self::HAS_MANY, 'Alunocontato', 'idAluno'),
			'alunoturmas' => array(self::HAS_MANY, 'Alunoturma', 'idAluno'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idAluno' => 'Cod. Aluno',
			'idUsuario' => 'Cod. Usuario',
			'nome' => 'Nome',
			'dtNasc' => 'Nascimento',
			'nomeMae' => 'Nome Mãe',
			'nomePai' => 'Nome Pai',
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

		$criteria->compare('idAluno',$this->idAluno);
		$criteria->compare('idUsuario',$this->idUsuario);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('dtNasc',$this->dtNasc,true);
		$criteria->compare('nomeMae',$this->nomeMae,true);
		$criteria->compare('nomePai',$this->nomePai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aluno the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
