<?php

namespace App\Http\DataValidation;

use App\Http\Model\PromoCodeData;
use Doctrine\Common\Collections\Collection;

class PromoCodeValidator
{
    public function validatePromoCode(?string $promoCode, ?Collection $promoCodeList): bool
    {
        if (!$promoCode) {
            return false;
        }

        /** @var null|PromoCodeData $promoCodeObject */
        foreach ($promoCodeList as $promoCodeObject) {
            if ($promoCodeObject->getCode() === $promoCode) {
                if ($promoCodeObject->getEndDate()->format('Y-m-d') >= date('Y-m-d')) {

                    return true;
                }

                break;
            }
        }

        return false;
    }
}
