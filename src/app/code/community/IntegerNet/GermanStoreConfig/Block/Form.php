<?php

class IntegerNet_GermanStoreConfig_Block_Form extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('germanstoreconfig/form.phtml');
        $this->setTitle(Mage::helper('germanstoreconfig') ->__('German Distribution for Magento'));
    }

    /**
     * Retrieve the POST URL for the form
     *
     * @return string URL
     */
    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/save');
    }

    public function getInputFields()
    {
        return array(
            array(
                'type' => 'text',
                'name' => 'general__imprint__shop_name',
                'label' => Mage::helper('germansetup')->__('Shop Name'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__company_first',
                'label' => Mage::helper('germansetup')->__('Company 1'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__company_second',
                'label' => Mage::helper('germansetup')->__('Company 2'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__street',
                'label' => Mage::helper('germansetup')->__('Street'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__zip',
                'label' => Mage::helper('germansetup')->__('Zip'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__city',
                'label' => Mage::helper('germansetup')->__('City'),
            ),
            array(
                'type' => 'select',
                'source_model' => 'adminhtml/system_config_source_country',
                'name' => 'general__imprint__country',
                'label' => Mage::helper('germansetup')->__('Country'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__telephone',
                'label' => Mage::helper('germansetup')->__('Telephone'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__fax',
                'label' => Mage::helper('germansetup')->__('Fax'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__email',
                'label' => Mage::helper('germansetup')->__('E-Mail'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__web',
                'label' => Mage::helper('germansetup')->__('Website'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__tax_number',
                'label' => Mage::helper('germansetup')->__('Tax number'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__vat_id',
                'label' => Mage::helper('germansetup')->__('USt.Nr.'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__court',
                'label' => Mage::helper('germansetup')->__('Register court'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__financial_office',
                'label' => Mage::helper('germansetup')->__('Financial office'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__ceo',
                'label' => Mage::helper('germansetup')->__('CEO'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__owner',
                'label' => Mage::helper('germansetup')->__('Owner'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__register_number',
                'label' => Mage::helper('germansetup')->__('Register number'),
                'optional' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__bank_account_owner',
                'label' => Mage::helper('germansetup')->__('Account owner'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__bank_account',
                'label' => Mage::helper('germansetup')->__('Account'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__bank_code_number',
                'label' => Mage::helper('germansetup')->__('Bank number'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__bank_name',
                'label' => Mage::helper('germansetup')->__('Bank name'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__swift',
                'label' => Mage::helper('germansetup')->__('SWIFT'),
            ),
            array(
                'type' => 'text',
                'name' => 'general__imprint__iban',
                'label' => Mage::helper('germansetup')->__('IBAN'),
            ),
        );
    }

    public function getValue($fieldname)
    {
        $fieldCode = implode('/', explode('__', $fieldname));

        return Mage::getStoreConfig($fieldCode);
    }
}
