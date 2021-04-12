<?php

namespace App\Manager;

use App\Http\DataValidation\PromoCodeValidator;
use App\Http\DTOTransformer\PromoCodeTransformer;
use App\Http\WSCalls\PromoCodeList;

class PromoCodeManager
{
    /**
     * @var PromoCodeList
     */
    private $promoCodeList;

    /**
     * @var PromoCodeTransformer
     */
    private $transformer;

    /**
     * @var PromoCodeValidator
     */
    private $validator;

    /**
     * PromoCodeManager constructor.
     * @param PromoCodeList $promoCodeList
     * @param PromoCodeTransformer $transformer
     * @param PromoCodeValidator $validator
     */
    public function __construct(
        PromoCodeList $promoCodeList,
        PromoCodeTransformer $transformer,
        PromoCodeValidator $validator
    ) {
        $this->promoCodeList = $promoCodeList;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    public function validatePromoCode(?string $promoCode): bool
    {
        $promoCodeArray = $this->promoCodeList->fetchAllPromoCode();

        // In POO, all is object. We can use the original format(array) if the scheme is really
        // complicated and it's gonna be heavy on transformation
        $promoCodeCollection = $this->transformer->arrayToObject($promoCodeArray);

        return $this->validator->validatePromoCode($promoCode, $promoCodeCollection);
    }
}
