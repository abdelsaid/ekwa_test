<?php

namespace App\Http\Model;

class OfferData
{
    /**
     * @var string
     */
    private $offerType;

    /**
     * @var string
     */
    private $offerName;

    /**
     * @var string
     */
    private $offerDescription;

    /**
     * @var array
     */
    private $validPromoCodeList;

    /**
     * @param string $offerType
     */
    public function setOfferType(string $offerType): void
    {
        $this->offerType = $offerType;
    }

    /**
     * @return string
     */
    public function getOfferType(): string
    {
        return $this->offerType;
    }

    /**
     * @param string $offerName
     */
    public function setOfferName(string $offerName): void
    {
        $this->offerName = $offerName;
    }

    /**
     * @return string
     */
    public function getOfferName(): string
    {
        return $this->offerName;
    }

    /**
     * @param string $offerDescription
     */
    public function setOfferDescription(string $offerDescription): void
    {
        $this->offerDescription = $offerDescription;
    }

    /**
     * @return string
     */
    public function getOfferDescription(): string
    {
        return $this->offerDescription;
    }

    /**
     * @param array $validPromoCodeList
     */
    public function setValidPromoCodeList(array $validPromoCodeList): void
    {
        $this->validPromoCodeList = $validPromoCodeList;
    }

    /**
     * @return array
     */
    public function getValidPromoCodeList(): array
    {
        return $this->validPromoCodeList;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
