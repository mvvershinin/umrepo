<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ServicesSection]].
 *
 * @see ServicesSection
 */
class ServicesSectionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ServicesSection[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ServicesSection|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
