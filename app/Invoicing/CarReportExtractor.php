<?php

declare(strict_types=1);

namespace App\Invoicing;

use App\Repository\CarRepository;
use App\Utils\Numberic;
use App\ValueObject\CarReport;
use App\ValueObject\FuelPurchase;
use Illuminate\Support\Collection;
use Nette\Utils\Strings;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Page;
use Webmozart\Assert\Assert;

final class CarReportExtractor
{
    /**
     * Matching typical line content:
     * "7028009678100061017 00033 06/09/22 1739  SSP  0123 007500 1135 VIA TRIESTE 6 DISTR. VIMERCATE      PP    49,99      29,60 1,689 0,000 1,689    49,99"
     *
     * @see https://regex101.com/r/zep7mO/1
     * @var string
     */
    private const FUEL_PURCHASE_REGEX = '#
        (?<num_card>\d{19})\s+
        (?<num_ticket>\d+)\s+
        (?<date>\d+\/\d+/\d+)\s
        (?<time>\d+)\s+
        (?<product_code>\w+)\s+
        (?<code_vehicle>\d+)\s+
        (?<kilometres>\d+)\s+
        (.*?)
        (?<sr>SV|PP|SF|SV)\s+
        (?<price>\d+\,\d+)\s+
        (?<volume>\d+\,\d+)\s+
        (?<basic_price>\d+,\d+)\s+
        (?<premium_discount>\d+,\d+)\s+
        (?<final_price>\d+,\d+)\s+
        (?<price_total>\d+,\d+)
    #x';

    public function __construct(
        private readonly CarRepository $carRepository
    ) {
    }

    /**
     * @return Collection<int, CarReport>
     */
    public function resolve(Document $document): Collection
    {
        $carReports = [];

        foreach ($document->getPages() as $page) {
            if (! $this->isInvoiceTable($page)) {
                continue;
            }

            $fuelPurchases = [];

            foreach ($page->getDataTm() as $lineData) {
                // key "0": position metadata
                // key "1": string contents
                $lineContents = $lineData[1];

                // car cost item
                if (! str_contains((string) $lineContents, 'TOTALE PAN')) {
                    $fuelPurchase = $this->createFullPurchaseIfMatch($lineContents);
                    if ($fuelPurchase instanceof FuelPurchase) {
                        $fuelPurchases[] = $fuelPurchase;
                    }
                } else {
                    // end of current car → sumup and add to itmes
                    $match = Strings::match($lineContents, '#TARGA/NOME\s+(?<plate_id>\w+)#');
                    Assert::isArray($match);

                    $plateId = $match['plate_id'];
                    Assert::string($plateId);

                    $fuelPurchasesCollection = new Collection($fuelPurchases);

                    $car = $this->carRepository->getCarByPlate($plateId);
                    $carReports[] = new CarReport($plateId, $fuelPurchasesCollection, $car);

                    // reset for the next car
                    $fuelPurchases = [];
                }
            }
        }

        Assert::allIsInstanceOf($carReports, CarReport::class);

        return new Collection($carReports);
    }

    private function createFullPurchaseIfMatch(string $lineContents): ?FuelPurchase
    {
        $match = Strings::match($lineContents, self::FUEL_PURCHASE_REGEX);
        if ($match === null) {
            return null;
        }

        return new FuelPurchase(
            $match['date'],
            (int) $match['kilometres'],
            Numberic::stringToFloat($match['volume']),
            Numberic::stringToFloat($match['price_total']),
        );
    }

    private function isInvoiceTable(Page $page): bool
    {
        return str_contains($page->getText(), 'ALLEGATO ALLA FATTURA');
    }
}
