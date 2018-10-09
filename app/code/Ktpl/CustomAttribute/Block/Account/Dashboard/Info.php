<?php
namespace Ktpl\CustomerAttribute\Block\Account\Dashboard;

use Magento\Framework\Exception\NoSuchEntityException;

class Info extends \Magento\Framework\View\Element\Template
{
    /** @var \Magento\Customer\Helper\View */
    protected $_helperView;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Customer\Helper\View $helperView
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Helper\View $helperView,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->_helperView = $helperView;
        parent::__construct($context, $data);
    }

    /**
     * Returns the Magento Customer Model for this block
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Get the full name of a customer
     *
     * @return string full name
     */
    public function getName()
    {
        return $this->_helperView->getCustomerName($this->getCustomer());
    }

    public function getNickname()
    {
        $customerId = $this->currentCustomer->getCustomerId();
        $objectManager = \Magento\Framework\App\objectManager::getInstance();
        $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);
        return $customer->getNickname();
    }

    /**
     * @return string
     */
    public function getChangePasswordUrl()
    {
        return $this->_urlBuilder->getUrl('customer/account/edit/changepass/1');
    }

    public function getIsSubscribed()
    {
        return $this->getSubscriptionObject()->isSubscribed();
    }
    protected function _toHtml()
    {
        return $this->currentCustomer->getCustomerId() ? parent::_toHtml() : '';
    }
}
