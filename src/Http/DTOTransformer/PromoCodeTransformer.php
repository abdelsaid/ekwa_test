<?php

namespace App\Http\DTOTransformer;

use App\Http\Model\PromoCodeData;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class PromoCodeTransformer
{
    public function arrayToObject(?array $data): Collection
    {
        $collection = new ArrayCollection();
        foreach ($data as $datum) {
            $collection->add(new PromoCodeData($datum['code'], $datum['discountValue'], $datum['endDate']));
        }

        return $collection;
    }
}
