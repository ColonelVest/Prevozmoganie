<?php

namespace StoreBundle\Services;

use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use StoreBundle\Entity\BuyItem;
use StoreBundle\Entity\Receipt;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use UserBundle\Entity\User;

class ReceiptHandler extends EntityHandler
{
    private $itemHandler;
    private $buyItemHandler;

    public function __construct(EntityManager $em,
        ApiResponseFormatter $responseFormatter,
        RecursiveValidator $validator,
        BuyItemHandler $buyItemHandler,
        ItemHandler $itemHandler
    )
    {
        parent::__construct($em, $responseFormatter, $validator);
        $this->buyItemHandler = $buyItemHandler;
        $this->itemHandler = $itemHandler;
    }

    /**
     * @param array $fmsData
     * @param User $user
     * @return null|object|Receipt
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveByFMSData(array $fmsData, User $user)
    {
        if (!isset($fmsData['document']['receipt'])) {
            throw new \InvalidArgumentException('Incorrect format of fms data!');
        }

        $receiptData = $fmsData['document']['receipt'];
        $receipt = $this->getRepository()->findOneBy(['fiscalNumber' => $receiptData['fiscalDriveNumber']]);

        if (is_null($receipt)) {

            $receipt = (new Receipt())
                ->setFiscalNumber($receiptData['fiscalDriveNumber'])
                ->setTotalSum($receiptData['totalSum'] / 100)
                ->setUser($user)
                ->setDateTime(\DateTime::createFromFormat('Y-m-d\TH:i:s', $receiptData['dateTime']));
            $this->em->persist($receipt);

            foreach ($receiptData['items'] as $buyItemData) {
                $item = $this->itemHandler->findOrCreate($buyItemData['name']);
                $buyItem = (new BuyItem())
                    ->setUser($user)
                    ->setIsBought(true)
                    ->setQuantity($buyItemData['quantity'])
                    ->setReceipt($receipt)
                    ->setItem($item);
                $receipt->addItem($buyItem);

                $buyItemCreationResult = $this->buyItemHandler->create($buyItem, false);
                if (!$buyItemCreationResult->getIsSuccess()) {
                    throw new \RuntimeException('Default buy item is not valid!');
                }
            }

            $this->em->flush();
        }

        return Result::createSuccessResult($receipt);
    }
    /**
     * @return EntityRepository
     */
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('StoreBundle:Receipt');
    }
}