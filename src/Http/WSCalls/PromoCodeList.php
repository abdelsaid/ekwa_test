<?php

namespace App\Http\WSCalls;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PromoCodeList
{
    /**
     * @var ContainerBagInterface
     */
    private $containerBag;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        HttpClientInterface $client,
        ContainerBagInterface $containerBag,
        LoggerInterface $logger
    ) {
        $this->httpClient = $client;
        $this->containerBag = $containerBag;
        $this->logger = $logger;
    }

    public function fetchAllPromoCode(): array
    {
        try {
            $response = $this->httpClient->request(
                Request::METHOD_GET,
                $this->containerBag->get('web_service_promo_code_list')
            );

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            $this->logger->alert(sprintf(
                'Detected problem with WS promo code calls with code %d: %s',
                $e->getCode(),
                $e->getMessage())
            );
            throw $e;
        } catch (DecodingExceptionInterface $e) {
            $this->logger->error('Can\'t decode the response message of WS promo code request');
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Unknown Problem with code %d: %s', $e->getCode(), $e->getMessage()));
        }
    }
}
