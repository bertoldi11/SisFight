<?php

/**
 * This is the model class for table "cheque".
 *
 * The followings are the available columns in table 'cheque':
 * @property integer $idCheque
 * @property integer $idPagamento
 * @property integer $idBanco
 * @property string $nome
 * @property string $ag
 * @property string $conta
 * @property integer $numero
 *
 * The followings are the available model relations:
 * @property Pagamento $idPagamento0
 * @property Banco $idBanco0
 */
class Cheque extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cheque';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idPagamento, idBanco, nome, ag, conta,numero', 'required'),
			array('idPagamento, idBanco, numero', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>100),
			array('ag', 'length', 'max'=>6),
			array('conta', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idCheque, idPagamento, idBanco, nome, ag, conta, numero', 'safe', 'on'=>'search'),
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
			'idPagamento0' => array(self::BELONGS_TO, 'Pagamento', 'idPagamento'),
			'idBanco0' => array(self::BELONGS_TO, 'Banco', 'idBanco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idCheque' => 'Id Cheque',
			'idPagamento' => 'Id Pagamento',
			'idBanco' => 'Banco',
			'nome' => 'Nome',
			'ag' => 'Agência',
			'conta' => 'Conta',
			'numero' => 'Número Cheque',
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

		$criteria->compare('idCheque',$this->idCheque);
		$criteria->compare('idPagamento',$this->idPagamento);
		$criteria->compare('idBanco',$this->idBanco);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('ag',$this->ag,true);
		$criteria->compare('conta',$this->conta,true);
		$criteria->compare('numero',$this->numero);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cheque the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
