<?php

namespace StoreBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
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

    /**
     * @param string $fiscalNumber
     * @param string $fiscalDocNumber
     * @param string $fiscalDocumentBasis
     * @param string $datetime
     * @param int $sumInKop
     * @return Result
     */
    public function checkReceipt(string $fiscalNumber, string $fiscalDocNumber, string $fiscalDocumentBasis, string $datetime, int $sumInKop)
    {
        $url = "https://proverkacheka.nalog.ru:9999/v1/ofds/*/inns/*/fss/{$fiscalNumber}/operations/1/tickets/{$fiscalDocNumber}?fiscalSign={$fiscalDocumentBasis}&date={$datetime}&sum={$sumInKop}";

        $response = $this->guzzleClient->get($url, [
            RequestOptions::HEADERS => [
                'Authorization' => $this->getAuthString()
            ],
        ]);

        return $response->getStatusCode() === 204
            ? Result::createSuccessResult()
            : Result::createErrorResult(ErrorMessages::FNS_HTTPS_FAIL);
    }

    /**
     * @param string $fiscalNumber
     * @param string $fiscalDocNumber
     * @param string $fiscalDocumentBasis
     * @return Result
     */
    public function getReceiptDetails(string $fiscalNumber, string $fiscalDocNumber, string $fiscalDocumentBasis)
    {
        $url = "https://proverkacheka.nalog.ru:9999/v1/inns/*/kkts/*/fss/{$fiscalNumber}/tickets/{$fiscalDocNumber}?fiscalSign={$fiscalDocumentBasis}&sendToEmail=no";

        $response = $this->guzzleClient->get($url, [
            RequestOptions::HEADERS => [
                'Authorization' => $this->getAuthString(),
                'Device-Id' => '',
                'Device-os' => ''
            ]
        ]);

        return $response->getStatusCode() === 200
            ? Result::createSuccessResult(json_decode($response->getBody(), true))
            : Result::createErrorResult(ErrorMessages::FNS_HTTPS_FAIL);
    }

    /**
     * @return string
     */
    private function getAuthString()
    {
        return 'Basic ' . base64_encode("{$this->receiptCheckUsername}:{$this->receiptCheckPwd}");
    }
}