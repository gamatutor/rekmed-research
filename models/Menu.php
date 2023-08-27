<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $menu_id
 * @property integer $menu_root
 * @property string $menu_nama
 * @property string $menu_icon
 * @property integer $menu_order
 * @property string $menu_route
 *
 * @property MenuAkses[] $menuAkses
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_root', 'menu_order'], 'integer'],
            [['menu_nama'], 'string', 'max' => 50],
            [['menu_icon', 'menu_route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'menu_root' => 'Menu Root',
            'menu_nama' => 'Menu Nama',
            'menu_icon' => 'Menu Icon',
            'menu_order' => 'Menu Order',
            'menu_route' => 'Menu Route',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuAkses()
    {
        return $this->hasMany(MenuAkses::className(), ['menu_id' => 'menu_id']);
    }
}
