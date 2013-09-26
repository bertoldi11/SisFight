<?php

/**
 * This is the model class for table "pagamento".
 *
 * The followings are the available columns in table 'pagamento':
 * @property integer $idPagamento
 * @property integer $idAlunoTurma
 * @property integer $idUsuario
 * @property string $valorPagar
 * @property string $dtCadastro
 * @property string $dtVencimento
 * @property string $status
 * @property string $dtPagamento
 * @property string $valorPago
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
			array('idAlunoTurma, idUsuario, valorPagar, dtCadastro, dtVencimento', 'required'),
			array('idAlunoTurma, idUsuario', 'numerical', 'integerOnly'=>true),
			array('valorPagar, valorPago', 'length', 'max'=>6),
			array('status', 'length', 'max'=>1),
			array('dtPagamento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idPagamento, idAlunoTurma, idUsuario, valorPagar, dtCadastro, dtVencimento, status, dtPagamento, valorPago', 'safe', 'on'=>'search'),
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
			'idPagamento' => 'Id Pagamento',
			'idAlunoTurma' => 'Id Aluno Turma',
			'idUsuario' => 'Id Usuario',
			'valorPagar' => 'Valor Pagar',
			'dtCadastro' => 'Dt Cadastro',
			'dtVencimento' => 'Dt Vencimento',
			'status' => 'Status',
			'dtPagamento' => 'Dt Pagamento',
			'valorPago' => 'Valor Pago',
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

		$criteria->compare('idPagamento',$this->idPagamento);
		$criteria->compare('idAlunoTurma',$this->idAlunoTurma);
		$criteria->compare('idUsuario',$this->idUsuario);
		$criteria->compare('valorPagar',$this->valorPagar,true);
		$criteria->compare('dtCadastro',$this->dtCadastro,true);
		$criteria->compare('dtVencimento',$this->dtVencimento,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('dtPagamento',$this->dtPagamento,true);
		$criteria->compare('valorPago',$this->valorPago,true);

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
