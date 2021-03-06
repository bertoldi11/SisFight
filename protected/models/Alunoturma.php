<?php

/**
 * This is the model class for table "alunoturma".
 *
 * The followings are the available columns in table 'alunoturma':
 * @property integer $idAlunoTurma
 * @property integer $idAluno
 * @property integer $idTipoAluno
 * @property integer $idTurma
 * @property integer $idModalidade
 * @property string $valor
 * @property string $status
 * @property string $dtPrimeiroPgto
 *
 * The followings are the available model relations:
 * @property Aluno $idAluno0
 * @property Modalidade $idModalidade0
 * @property Tipoaluno $idTipoAluno0
 * @property Turma $idTurma0
 * @property Pagamento[] $pagamentos
 */
class Alunoturma extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alunoturma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idAluno, idTipoAluno', 'required'),
			array('idAluno, idTipoAluno, idTurma, idModalidade', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>6),
			array('status', 'length', 'max'=>1),
            array('dtPrimeiroPgto', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idAlunoTurma, idAluno, idTipoAluno, idTurma, idModalidade, valor, status, dtPrimeiroPgto', 'safe', 'on'=>'search'),
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
			'idModalidade0' => array(self::BELONGS_TO, 'Modalidade', 'idModalidade'),
			'idTipoAluno0' => array(self::BELONGS_TO, 'Tipoaluno', 'idTipoAluno'),
			'idTurma0' => array(self::BELONGS_TO, 'Turma', 'idTurma'),
			'pagamentos' => array(self::HAS_MANY, 'Pagamento', 'idAlunoTurma'),
		);
	}

    protected function beforeSave()
    {
        parent::beforeSave();
        $this->dtPrimeiroPgto = Formatacao::formatData($this->dtPrimeiroPgto,'/','-');
        return true;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idAlunoTurma' => 'Id Aluno Turma',
			'idAluno' => 'Id Aluno',
			'idTipoAluno' => 'Tipo Aluno',
			'idTurma' => 'Turma',
			'idModalidade' => 'Modalidade',
			'valor' => 'Valor',
			'status' => 'Status',
            'dtPrimeiroPgto' => '1º Pagamento',
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

		$criteria->compare('idAlunoTurma',$this->idAlunoTurma);
		$criteria->compare('idAluno',$this->idAluno);
		$criteria->compare('idTipoAluno',$this->idTipoAluno);
		$criteria->compare('idTurma',$this->idTurma);
		$criteria->compare('idModalidade',$this->idModalidade);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('status',$this->status,true);
        $criteria->compare('dtPrimeiroPgto',$this->dtPrimeiroPgto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alunoturma the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
