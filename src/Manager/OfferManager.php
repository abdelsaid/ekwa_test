<?php

namespace App\Manager;

use App\Http\DTOTransformer\OfferTransformer;
use App\Http\Model\OfferData;
use App\Http\WSCalls\OfferList;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class OfferManager
{
    /**
     * @var OfferList
     */
    private $offerList;

    /**
     * @var OfferTransformer
     */
    private $transformer;

    /**
     * OfferManager constructor.
     * @param OfferList $offerList
     * @param OfferTransformer $transformer
     */
    public function __construct(
        OfferList $offerList,
        OfferTransformer $transformer
    ) {
        $this->offerList = $offerList;
        $this->transformer = $transformer;
    }

    public function getValidOffers(?string $promoCode): ArrayCollection
    {
        $offersAsArray = $this->offerList->fetchAllOffers();

        $offersCollection = $this->transformer->arrayToObject($offersAsArray);

        return $this->getValidOffersForPromoCode($promoCode, $offersCollection);
    }

    private function getValidOffersForPromoCode(?string $promoCode, Collection $offers): ArrayCollection
    {
        $result = new ArrayCollection();
        /** @var null|OfferData $offer */
        foreach ($offers as $offer) {
            if (in_array($promoCode, $offer->getValidPromoCodeList())) {
                $result->add($offer);
            }
        }

        return $result;
    }
}
