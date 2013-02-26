<?php
/**
 * Der Modulprogrammierer - Vinai Kopp, Rico Neitzel GbR
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @copyright  Copyright (c) 2009 Der Modulprogrammierer - Vinai Kopp, Rico Neitzel GbR http://der-modulprogrammierer.de/
 * @copyright  Copyright (c) 2012 Netresearch GmbH 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Source model for baseprice attributes
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
abstract class DerModPro_BasePrice_Model_Entity_Source_Baseprice_Abstract
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
	protected $_basePriceDefaultKey = '';

	protected $_options;

	public function toOptionArray()
	{
		if (!$this->_options) {
			$this->_options = Mage::getModel('baseprice/baseprice')->toOptionArray();
		}
		return $this->_options;
	}

	public function getAllOptions()
	{
		return $this->toOptionArray();
	}

	public function getDefaultValue()
	{
		return Mage::helper('baseprice')->getConfig('default_' . $this->getAttribute()->getAttributeCode());
	}

	/**
	 * Bugfix for Magento 1.3 - do not return the option array entry, only the label.
	 *
	 * @param mixed $value
	 * @return string
	 */
	public function getOptionText($value)
	{
		$option = parent::getOptionText($value);
		if (is_array($option) && isset($option['label']))
		{
			$option = $option['label'];
		}
		return $option;
	}

	public function getFlatColums()
	{
		return array($this->getAttribute()->getAttributeCode() => array(
					'type'      => 'varchar(255)',
					'unsigned'  => false,
					'is_null'   => true,
					'default'   => $this->getDefaultValue(),
					'extra'     => null
		));
	}

    /**
     * Retrieve Select For Flat Attribute update
     *
     * @param int $store
     * @return Varien_Db_Select|null
     */
    public function getFlatUpdateSelect($store)
    {
		$attribute = $this->getAttribute();
        $joinCondition = "`e`.`entity_id`=`t1`.`entity_id`";
        if ($attribute->getFlatAddChildData()) {
            $joinCondition .= " AND `e`.`child_id`=`t1`.`entity_id`";
        }
        $select = $attribute->getResource()->getReadConnection()->select()
            ->joinLeft(
                array('t1' => $attribute->getBackend()->getTable()),
                $joinCondition,
                array()
                )
            ->joinLeft(
                array('t2' => $attribute->getBackend()->getTable()),
                "t2.entity_id = t1.entity_id"
                    . " AND t1.entity_type_id = t2.entity_type_id"
                    . " AND t1.attribute_id = t2.attribute_id"
                    . " AND t2.store_id = {$store}",
                array($attribute->getAttributeCode() => "IFNULL(t2.value, t1.value)"))
            ->where("t1.entity_type_id=?", $attribute->getEntityTypeId())
            ->where("t1.attribute_id=?", $attribute->getId())
            ->where("t1.store_id=?", 0);
        if ($attribute->getFlatAddChildData()) {
            $select->where("e.is_child=?", 0);
        }
        return $select;
    }
}