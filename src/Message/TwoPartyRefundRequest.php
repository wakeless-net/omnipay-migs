<?php

namespace Omnipay\Migs\Message;

/**
 * Migs Purchase Request
 */
class TwoPartyRefundRequest extends AbstractRequest
{
    protected $action = 'refund';

    public function getData()
    {
        $this->validate('amount', 'transactionId', "transactionNumber");

        $data = $this->getBaseData();
        $data["vpc_TransNo"] = $this->getTransactionNumber();
        $data["vpc_User"] = $this->getUser();
        $data["vpc_Password"] = $this->getPassword();
#       $data['vpc_CardNum'] = $this->getCard()->getNumber();
#       $data['vpc_CardExp'] = $this->getCard()->getExpiryDate('ym');
#       $data['vpc_CardSecurityCode'] = $this->getCard()->getCvv();
#       $data['vpc_SecureHash']  = $this->calculateHash($data);

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, $data)->send();

        return $this->response = new Response($this, $httpResponse->getBody());
    }

    public function getEndpoint()
    {
        return $this->endpoint.'vpcdps';
    }

    public function getTransactionNumber()
    {
        return $this->getParameter('transactionNumber');
    }

    public function setTransactionNumber($value)
    {
        return $this->setParameter('transactionNumber', $value);
    }

    public function getUser()
    {
        return $this->getParameter('user');
    }

    public function setUser($value)
    {
        return $this->setParameter('user', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }
}
