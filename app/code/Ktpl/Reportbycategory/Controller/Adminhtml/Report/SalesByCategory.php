<?php
/*
 * Copyright © 2018 Krish Technolabs. All rights reserved.
 * See COPYING.txt for license details
 */
namespace Ktpl\Reportbycategory\Controller\Adminhtml\Report;
/**
 * Description of SalesByCategory
 *
 * @author Krish Technolabs
 */
use Magento\Reports\Model\Flag;

class SalesByCategory extends \Magento\Backend\App\Action
//\Magento\Reports\Controller\Adminhtml\Report\Sales
{
    public function execute()
    {
//        $this->_showLastExecutionTime(Flag::REPORT_ORDER_FLAG_CODE, 'sales');
//
//        $this->_initAction()->_setActiveMenu(
//            'Magento_Reports::report_salesroot_sales_by_category'
//        )->_addBreadcrumb(
//            __('Sales Report By Category'),
//            __('Sales Report By Category')
//        );
//        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Orders Report By Category'));
//
//        $gridBlock = $this->_view->getLayout()->getBlock('adminhtml_sales_sales.grid');
//        $filterFormBlock = $this->_view->getLayout()->getBlock('grid.filter.form');
//
//        $this->_initReportAction([$gridBlock, $filterFormBlock]);
print_r("salesByCategory.....");
        $this->_view->renderLayout();
    }
    
}
