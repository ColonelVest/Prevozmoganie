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
    public function checkReceipt(string $fiscalNumber, string $fiscalDocNumber, string $fiscalDocumentBasis, string $datetime, int $sumInKop)
    {
        $url = "https://proverkacheka.nalog.ru:9999/v1/ofds/*/inns/*/fss/{$fiscalNumber}/operations/1/tickets/{$fiscalDocNumber}?fiscalSign={$fiscalDocumentBasis}&date={$datetime}&sum={$sumInKop}";

        return $this->guzzleClient->get($url, [
            RequestOptions::HEADERS => [
                'Authorization' => $this->getAuthString()
            ]
        ]);
    }

    public function getReceiptDetails(string $fiscalNumber, string $fiscalDocNumber, string $fiscalDocumentBasis)
    {
        $url = "https://proverkacheka.nalog.ru:9999/v1/inns/*/kkts/*/fss/{$fiscalNumber}/tickets/{$fiscalDocNumber}?fiscalSign={$fiscalDocumentBasis}&sendToEmail=no";

        return $this->guzzleClient->get($url, [
            RequestOptions::HEADERS => [
                'Authorization' => $this->getAuthString(),
                'Device-Id' => '',
                'Device-os' => ''
            ]
        ]);
    }

    /**
     * @return string
     */
    private function getAuthString()
    {
        return 'Basic ' . base64_encode("{$this->receiptCheckUsername}:{$this->receiptCheckPwd}");
    }
}