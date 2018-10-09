<?php

namespace Ktpl\CustomerNickname\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{ 

    private $customerSetupFactory;      

    public function __construct(\Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory)
    {
      $this->customerSetupFactory = $customerSetupFactory;
    }

    public function install(ModuleDataSetupInterface
    $setup, ModuleContextInterface $context)
    {
        /** @var CustomerSetup $customerSetup */

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $setup->startSetup();

        $attributeCode = "customernickname";

        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);          

        $customerSetup->addAttribute('customer',
        'customernickname', [
        'label' => 'customer nickname',
        'type' => 'text',
        'frontend_input' => 'text',
        'required' => true,
        'visible' => true,
        'system'=> 0,
        'position' => 105,
        ]);

        $customerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'customernickname');
        $customerAttribute->setData('used_in_forms',['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address', 'customer_account_create']);
        $customerAttribute->setData("is_used_for_customer_segment", true)
            ->setData("is_system", 0)
            ->setData("is_user_defined", 1)
            ->setData("is_visible", 1)
            ->setData("is_used_in_grid", 1)
            ->setData("is_visible_in_grid", 1)
            ->setData("is_filterable_in_grid", 1)
            ->setData("is_searchable_in_grid", 1)
            ->setData("sort_order", 65);
        $customerAttribute->save();

        $setup->endSetup();
    }
}