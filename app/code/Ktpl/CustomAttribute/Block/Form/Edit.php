<?php

namespace Ktpl\CustomAttribute\Block\Form;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;


class Edit extends \Magento\Customer\Block\Account\Dashboard
{

    protected function getFormData()
    {
        $data = $this->getData('form_data');
        if ($data === null) {
            $formData = $this->customerSession->getCustomerFormData(true);
            $data = [];
            if ($formData) {
                $data['data'] = $formData;
                $data['customer_data'] = 1;
            }
            $this->setData('form_data', $data);
        }
        return $data;
    }

    public function getNickname()
    {
        $customerId = $this->customerSession->getCustomerId();
        $objectManager = \Magento\Framework\App\objectManager::getInstance();
        $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);
        return $customer->getNickname();
    }

    public function restoreSessionData(\Magento\Customer\Model\Metadata\Form $form, $scope = null)
    {
        $formData = $this->getFormData();
        if (isset($formData['customer_data']) && $formData['customer_data']) {
            $request = $form->prepareRequest($formData['data']);
            $data = $form->extractData($request, $scope, false);
            $form->restoreData($data);
        }

        return $this;
    }

}
