<?php
namespace common\modules\user\models;
use Yii;
use yii\base\Model;
class Teacher extends Model{
    public $email;
    public $username;
    public $password;
    public $confirmPassword;
    public $fname;
    public $lname;
    public $tel;
    
    
    public function rules()
    {
        return[
            [['email','username','password','confirmPassword','fname','lname','tel'],'required'],
            ['confirmPassword', 'compare', 'compareAttribute'=>'password', 'message'=>"รหัสผ่านไม่ตรงกัน" ],
            ['password', 'string', 'min' => 6, 'max' => 72],
            ['tel', 'string', 'min' => 10, 'max' => 10,'message'=>'เบอร์โทรศัพทต้องมี 10 ตัว']
        ];
    }
    public function attributeLabels()
    {
        return [
            'email'    => Yii::t('user', 'Email'),
            'username' => Yii::t('user', 'ชื่อผู้ใช้งาน'),
            'password' => Yii::t('user', 'รหัสผ่าน'),
            'confirmPassword' => Yii::t('user', 'ยืนยันรหัสผ่าน'),
            'fname' => Yii::t('user', 'ชื่อ'),
            'lname' => Yii::t('user', 'นามสกุล'),
            'tel' => Yii::t('user', 'เบอร์โทรศัพท์'),
            
        ];
    }
}
