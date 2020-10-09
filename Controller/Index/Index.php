<?php

namespace WebsTheWord\VatValidation\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Vat $vat
    ) {
        parent::__construct($context);
        $this->vat = $vat;
    }

    public function execute()
    {
        $response = [
            'success' => true, 
            'message' => '', 
            'style' => '',
        ];

        try {
            $result = $this->vat->checkVatNumber(
                $this->getRequest()->getPost('countryCode'),
                $this->getRequest()->getPost('vatNumber')
            );
            if((int)$result->getIsValid() == 1){
                $message = __('VAT number is Valid');
                $response = ['success' => 'true', 'message' => $message, 'style' => 'color:#008000;'];
            }else{
                $message = __('VAT number is Invalid');
                $response = ['success' => 'true', 'message' => $message, 'style' => 'color:#ff0000;'];
            }
        } catch (\Exception $e){
            $message = $e->getMessage();
            $response = ['success' => 'false', 'message' => $message];
        }

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($response);
        return $resultJson;
    }
}