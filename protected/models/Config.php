<?php

/**
 * This is the model class for table "config".
 *
 * The followings are the available columns in table 'config':
 * @property integer $id
 * @property integer $last_update
 */
class Config extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('last_update_zz2,'
                            . 'last_update_zz3,'
                            . 'last_update_zz1,'
                            
                            . 'last_update_en1,'
                            . 'last_update_en2,'
                            . 'last_update_en3,'
                            
                            . 'last_update_de1,'
                            
                            . 'last_update_nl1,'
                            
                            . 'last_update_fr1,'
                            . 'last_update_fr2,'
                            
                            . 'last_update_pl1,'
                            . 'last_update_pl2,'
                            
                            . 'last_update_ru1,'
                            
                            . 'last_update_br1,'
                            
                            . 'last_update_us1,'
                            
                            . 'last_update_es1,'
                            
                            . 'last_update_it1,'
                            
                            . 'last_update_gr1,'
                            
                            . 'last_update_cz1,'
                            
                            . 'last_update_pt1,'
                            
                            . 'last_update_se1'
                            
                            . 'last_update_no1,'
                            
                            . 'last_update_dk1,'
                            
                            . 'last_update_fi1,'
                            
                            . 'last_update_sk1,'
                            
                            . 'last_update_ro1,'
                            
                            . 'last_update_hu1,'
                            
                            . 'last_update_ar1,'
                            
                            . 'last_update_de2'
                            
                            
                            . '', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, last_update', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'last_update' => 'Last Update',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('last_update',$this->last_update);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
