<?php

namespace Omnipay\Migs\Message;

use Omnipay\Tests\TestCase;

class TwoPartyPurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new TwoPartyRefundRequest($this->getHttpClient(), $this->getHttpRequest());
    }


    public function testPurchase()
    {
        $this->setMockHttpResponse('TwoPartyRefundSuccess.txt');

        $this->request->initialize(
            array(
                'amount' => '12.00',
                'transactionId' => 123,
                'merchantId'                   => '123',
                'merchantAccessCode'           => '123',
                'secureHash'                   => '123',
                "user" => "RefundUser",
                "password" => "RefundPassword"
            )
        );

        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Migs\Message\Response', $response);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('12345', $response->getTransactionReference());
        $this->assertSame('Approved', $response->getMessage());
        $this->assertNull($response->getCode());
        $this->assertArrayHasKey('vpc_SecureHash', $response->getData());
    }
}
