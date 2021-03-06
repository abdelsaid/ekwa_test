<?php

namespace App\Command;

use App\Manager\OfferManager;
use App\Manager\PromoCodeManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ValidatePromoCodeCommand extends Command
{
    protected static $defaultName = 'promo-code:validate';
    protected static $defaultDescription = 'Vérifier la validité d\'un code promo, et récupérer les offres associées';
    /**
     * @var PromoCodeManager
     */
    private $promoCodeManager;
    /**
     * @var OfferManager
     */
    private $offerManager;

    /**
     * ValidatePromoCodeCommand constructor.
     * @param PromoCodeManager $promoCodeManager
     * @param OfferManager $offerManager
     */
    public function __construct(PromoCodeManager $promoCodeManager, OfferManager $offerManager)
    {
        $this->promoCodeManager = $promoCodeManager;
        $this->offerManager = $offerManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('promoCode', InputArgument::REQUIRED, 'Identifiant du code promo')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $promoCode = $input->getArgument('promoCode');

        if ($promoCode) {
            $io->note(sprintf('Vous avez passé l\'argument: %s', $promoCode));
        }

        $isValidPromoCode = $this->promoCodeManager->validatePromoCode($promoCode);
        if (!$isValidPromoCode) {
            $io->error(sprintf(
                    'There promo code %s is not valid',
                    $promoCode)
            );

            return Command::SUCCESS;
        }

        $validOffers = $this->offerManager->getValidOffers($promoCode);
        if ($validOffers->count() > 0) {
            $io->success(sprintf(
                'There is %d offer(s) found with the \'%s\' promo code',
                    $validOffers->count(),
                $promoCode)
            );

            $this->writeDataInFile($validOffers);

        }

        return Command::SUCCESS;
    }

    private function writeDataInFile(ArrayCollection $validOffers)
    {
        $file = __DIR__ . '/../../var/log/validOffers.txt';

        $fileFp = fopen($file, 'a');
        foreach ($validOffers as $validOffer) {
            fwrite($fileFp, serialize($validOffer->toArray()) . PHP_EOL);

        }

        fclose($fileFp);
    }
}
