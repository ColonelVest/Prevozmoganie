<?php

namespace StoreBundle\Services;

use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use StoreBundle\Entity\BuyItem;
use StoreBundle\Entity\Receipt;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use UserBundle\Entity\User;

class ReceiptHandler extends EntityHandler
{
    private $itemHandler;
    private $buyItemHandler;
    private $storeHttp;

    public function __construct(EntityManager $em,
        RecursiveValidator $validator,
        BuyItemHandler $buyItemHandler,
        ItemHandler $itemHandler,
        StoreHttp $storeHttp
    )
    {
        parent::__construct($em, $validator);
        $this->buyItemHandler = $buyItemHandler;
        $this->itemHandler = $itemHandler;
        $this->storeHttp = $storeHttp;
    }

    /**
     * @param array $fmsData
     * @param User $user
     * @return Result
     * @throws \Doctrine\ORM\ORMException
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
                ->setCashier($receiptData['operator'])
                ->setCashTotalSum($receiptData['cashTotalSum'])
                ->setEcashTotalSum($receiptData['ecashTotalSum'])
                ->setStoreInn($receiptData['userInn'])
                ->setDateTime(\DateTime::createFromFormat('Y-m-d\TH:i:s', $receiptData['dateTime']));

            if (isset($receiptData['retailPlaceAddress'])) {
                $receipt->setStoreAddress($receiptData['retailPlaceAddress']);
            }
            if (isset($receiptData['user'])) {
                $receipt->setStoreName($receiptData['user']);
            }

            $this->em->persist($receipt);

            foreach ($receiptData['items'] as $buyItemData) {
                $buyItem = (new BuyItem())
                    ->setUser($user)
                    ->setIsBought(true)
                    ->setQuantity($buyItemData['quantity'])
                    ->setTitle($buyItemData['name'])
                    ->setReceipt($receipt);

                /** @var BuyItem $existedBuyItem */
                $existedBuyItems = $this->em
                    ->getRepository('StoreBundle:BuyItem')
                    ->getByTitleWithItem($buyItem->getTitle());
                $existedBuyItem = empty($existedBuyItems) ? null : $existedBuyItems[0];

                if (!is_null($existedBuyItem) && !is_null($existedBuyItem->getItem())) {
                    $buyItem->setItem($existedBuyItem->getItem());
                }
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
     * @param ParameterBag $bag
     * @param User $user
     * @return Result
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveByReceiptData(ParameterBag $bag, User $user)
    {
        $result = $this->storeHttp
            ->checkReceipt($bag->get('fn'), $bag->get('i'), $bag->get('fp'), $bag->get('t'), $bag->getInt('s'));
        if (!$result->getIsSuccess()) {
            return $result;
        }

        $result = $this->storeHttp
            ->getReceiptDetails($bag->get('fn'), $bag->get('i'), $bag->get('fp'));
        if (!$result->getIsSuccess()) {
            return $result;
        }

        return $this->saveByFMSData($result->getData(), $user);
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('StoreBundle:Receipt');
    }
}