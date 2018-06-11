<?php

namespace StoreBundle\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class StoreHttp
{
    private $guzzleClient;
    private $receiptCheckUsername;
    private $receiptCheckPwd;

    public function __construct(string $receiptCheckUsername, string $receiptCheckPwd)
    {
        $this->guzzleClient = new Client();
        $this->receiptCheckUsername = $receiptCheckUsername;
        $this->receiptCheckPwd = $receiptCheckPwd;
    }
    public function checkReceipt()
    {
        
    }

    public function getReceiptDetails(string $fiscalNumber, string $fiscalDocNumber, string $fiscalDocumentBasis)
    {
        $url = "https://proverkacheka.nalog.ru:9999/v1/inns/*/kkts/*/fss/{$fiscalNumber}/tickets/{$fiscalDocNumber}?fiscalSign={$fiscalDocumentBasis}&sendToEmail=no";

         $this->guzzleClient->get($url, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Basic ' . base64_encode("{$this->receiptCheckUsername}:{$this->receiptCheckPwd}"),
                'Device-Id' => '123',
                'Device-os' => 'Android 4.4.4'
            ]
        ]);

        return $this->guzzleClient->get($url, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Basic ' . base64_encode("{$this->receiptCheckUsername}:{$this->receiptCheckPwd}"),
                'Device-Id' => '123',
                'Device-os' => 'Android 4.4.4'
            ]
        ]);
    }
}