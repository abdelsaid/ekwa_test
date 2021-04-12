<?php

namespace App\Http\DTOTransformer;

use App\Http\Model\OfferData;
use App\Http\Model\PromoCodeData;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class OfferTransformer
{
    public function arrayToObject(?array $data): Collection
    {
        $collection = new ArrayCollection();
        foreach ($data as $datum) {
            $object = $this->generateObject($datum);
            $collection->add($object);
        }

        return $collection;
    }

    private function generateObject($data)
    {
        $object = new OfferData();
        foreach ($data as $option => $value) {
            $method = 'set' . ucfirst($option);
            if (method_exists(OfferData::class, $method)) {
                $object->$method($value);
            }
        }

        return $object;
    }
}
