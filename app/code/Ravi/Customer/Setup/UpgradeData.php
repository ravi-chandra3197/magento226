<?php
namespace Ravi\Customer\Setup;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;

class UpgradeData implements UpgradeDataInterface
{

    /**
     * @var CategorySetupFactory
     */
    private $catalogSetupFactory;

    /**
     * @var StoreManager
     */
    private $storeManager;

    public function __construct(
        //CategorySetupFactory $categorySetupFactory, 
        CustomerSetupFactory $customerSetupFactory, 
        StoreManager $storeManager, 
        \Psr\Log\LoggerInterface $logger
    )
    {
        
        //$this->catalogSetupFactory = $categorySetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->storeManager = $storeManager;
        $this->_logger = $logger;
        $this->_logger->addDebug("\n\n <--------  __construct UpgradeData -------->\n ");
    }

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(
    ModuleDataSetupInterface $setup, ModuleContextInterface $context
    )
    {

        $dbVersion = $context->getVersion();
        $this->_logger->addDebug("\n\n <--------  function upgrade-------->\n ");
 
      if (version_compare($dbVersion, '1.0.4') > 0) {
            /** @var CustomerSetup $customerSetup */
          
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
            $this->_logger->addDebug("\n\n <--------  function upgrade \n\t  end if-------->\n ");
            $setup->startSetup();

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->updateAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'nickname',
            [
                'type'         => 'varchar',
                'label'        => 'Nick Name',
                'input'        => 'text',
                'required'     => true,
                'visible'      => true,
                'user_defined' => true,
                'position'     => 5,
                'sort_order' => 5,
                'system'       => 0,
                'forms'        => array('adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create','checkout_register'),
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
                'searchable' => true,
                'filterable' => true,
            ]
        );
        
        $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'sample_attribute');

        // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
        $sampleAttribute->setData("is_used_for_customer_segment", true);
        $sampleAttribute->setData(
            'used_in_forms',
            ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create','checkout_register']

        );
        $sampleAttribute->save();
        }
    }

}
