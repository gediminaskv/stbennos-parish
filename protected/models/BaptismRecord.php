<?php

/**
 * This is the model class for table "baptisms".
 *
 * The followings are the available columns in table 'baptisms':
 * @property integer $id
 * @property integer $member_id
 * @property string $dob
 * @property string $baptism_dt
 * @property string $baptism_place
 * @property string $name
 * @property integer $sex
 * @property string $fathers_name
 * @property string $mothers_name
 * @property string $mother_tongue
 * @property string $residence
 * @property string $godfathers_name
 * @property string $godmothers_name
 * @property string $minister
 * @property string $ref_no
 *
 * The followings are the available model relations:
 * @property BaptismCerts[] $baptismCerts
 */
class BaptismRecord extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaptismRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'baptisms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, fathers_name, mothers_name, sex, baptism_dt, dob', 'required'),
			array('sex, member_id', 'numerical', 'integerOnly'=>true),
			array('name, baptism_place', 'length', 'max'=>50),
			array('fathers_name, mothers_name, godfathers_name, godmothers_name, minister', 'length', 'max'=>75),
			array('residence, mother_tongue', 'length', 'max'=>25),
			array('ref_no', 'length', 'max'=>10),
			array('dob, baptism_dt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, dob, baptism_dt, name, sex, fathers_name, mothers_name, residence, godfathers_name, godmothers_name, minister, ref_no', 'safe', 'on'=>'search'),
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
			'baptismCerts' => array(self::HAS_MANY, 'BaptismCertificate', 'baptism_id'),
			'member' => array(self::BELONGS_TO, 'People', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dob' => 'Dob',
			'baptism_dt' => 'Baptism Date',
			'name' => 'Name',
			'sex' => 'Sex',
			'fathers_name' => 'Father’s Name',
			'mothers_name' => 'Mother’s Name',
			'residence' => 'Residence',
			'godfathers_name' => 'Godfather’s Name',
			'godmothers_name' => 'Godmother’s Name',
			'minister' => 'Minister',
			'ref_no' => 'Ref No',
			'baptism_place' => 'Place of Baptism',
			'mother_tongue' => 'Mother Tongue',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('baptism_dt',$this->baptism_dt,true);
		$criteria->compare('baptism_place',$this->baptism_place,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('fathers_name',$this->fathers_name,true);
		$criteria->compare('mothers_name',$this->mothers_name,true);
		$criteria->compare('mother_tongue',$this->mother_tongue,true);
		$criteria->compare('residence',$this->residence,true);
		$criteria->compare('godfathers_name',$this->godfathers_name,true);
		$criteria->compare('godmothers_name',$this->godmothers_name,true);
		$criteria->compare('minister',$this->minister,true);
		$criteria->compare('ref_no',$this->ref_no,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function get_refno() {
		$recs = BaptismRecord::model()->findAll(array(
			'condition'	=> 'year(baptism_dt)=year(:baptism_dt) and id<=:id',
			'params'	=> array(':baptism_dt' => $this->baptism_dt, ':id' => $this->id)
		));
		return date_format(new DateTime($this->baptism_dt), 'Y') . '/' . count($recs);
	}
}
