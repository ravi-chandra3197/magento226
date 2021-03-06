<?php

namespace Ktpl\CustomAttribute\Setup;

use Magento\Framework\Module\Setup\Migration;
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

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $entityTypeId = $customerSetup->getEntityTypeId(\Magento\Customer\Model\Customer::ENTITY);

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, "nickname",  array(
            "type"      => "varchar",
            "backend"   => "",
            "label"     => "Nickname",
            "input"     => "text",
            "visible"   => true,
            "required"  => true,
            "default"   => "",
            "frontend"  => "",
            "unique"    => false,
            "note"      => ""

        ));

        $regulation   = $customerSetup->getAttribute(\Magento\Customer\Model\Customer::ENTITY, "nickname");

        $regulation = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'nickname');
        $used_in_forms[]="adminhtml_customer";
        $used_in_forms[]="checkout_register";
        $used_in_forms[]="customer_account_create";
        $used_in_forms[]="customer_account_edit";
        $used_in_forms[]="adminhtml_checkout";
        $regulation->setData("used_in_forms", $used_in_forms)
            ->setData("is_used_for_customer_segment", true)
            ->setData("is_system", 0)
            ->setData("is_user_defined", 1)
            ->setData("is_visible", 1)
            ->setData("is_used_in_grid", 1)
            ->setData("is_visible_in_grid", 1)
            ->setData("is_filterable_in_grid", 1)
            ->setData("is_searchable_in_grid", 1)
            ->setData("sort_order", 65);
        $regulation->save();

        $installer->endSetup();
    }
}