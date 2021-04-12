<?php

namespace App\Http\Model;

use DateTime;

class PromoCodeData
{

    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $discountValue;

    /**
     * @var DateTime
     */
    private $endDate;

    /**
     * PromoCodeData constructor.
     * @param string $code
     * @param int $discountValue
     * @param string $endDate
     */
    public function __construct(string $code, int $discountValue, string $endDate)
    {
        $this->code = $code;
        $this->discountValue = $discountValue;
        $this->endDate = DateTime::createFromFormat ( 'Y-m-d' , $endDate);
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param int $discountValue
     */
    public function setDiscountValue(int $discountValue): void
    {
        $this->discountValue = $discountValue;
    }

    /**
     * @return int
     */
    public function getDiscountValue(): int
    {
        return $this->discountValue;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }
}
