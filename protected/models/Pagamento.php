<?php

/**
 * This is the model class for table "pagamento".
 *
 * The followings are the available columns in table 'pagamento':
 * @property integer $idPagemento
 * @property integer $idAlunoTurma
 * @property integer $idUsuario
 * @property string $valor
 * @property string $dtPagamento
 * @property integer $mesRef
 * @property integer $anoRef
 *
 * The followings are the available model relations:
 * @property Alunoturma $idAlunoTurma0
 * @property Usuario $idUsuario0
 */
class Pagamento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pagamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idAlunoTurma, idUsuario, valor, dtPagamento, mesRef, anoRef', 'required'),
			array('idAlunoTurma, idUsuario, mesRef, anoRef', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idPagemento, idAlunoTurma, idUsuario, valor, dtPagamento, mesRef, anoRef', 'safe', 'on'=>'search'),
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
			'idAlunoTurma0' => array(self::BELONGS_TO, 'Alunoturma', 'idAlunoTurma'),
			'idUsuario0' => array(self::BELONGS_TO, 'Usuario', 'idUsuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPagemento' => 'Id Pagemento',
			'idAlunoTurma' => 'Id Aluno Turma',
			'idUsuario' => 'Id Usuario',
			'valor' => 'Valor',
			'dtPagamento' => 'Pagamento',
			'mesRef' => 'Mês Referência',
			'anoRef' => 'Ano Referência',
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

		$criteria->compare('idPagemento',$this->idPagemento);
		$criteria->compare('idAlunoTurma',$this->idAlunoTurma);
		$criteria->compare('idUsuario',$this->idUsuario);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('dtPagamento',$this->dtPagamento,true);
		$criteria->compare('mesRef',$this->mesRef);
		$criteria->compare('anoRef',$this->anoRef);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pagamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
