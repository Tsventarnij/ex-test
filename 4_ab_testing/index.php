<?php
require __DIR__.'/vendor/autoload.php';

use Exads\ABTestData;

class MyClass
{
    /**
     * @var ABTestData
     */
    private $abTest;

    public function __construct(int $promoId)
    {
        $this->abTest = new ABTestData($promoId);
    }

    public function getName(): string
    {
        return $this->abTest->getPromotionName();
    }

    public function getDesign()
    {
        $designs = $this->abTest->getAllDesigns();

        if (count ($designs) == 0)
            return "No designs to choose";

        $rand = rand(1, 100);
        $sum = 0;
        $chosenDesign = null;

        foreach ($designs as $design) {
            $sum += $design['splitPercent'];
            if ($sum >= $rand) {
                $chosenDesign = $design;
                break;
            }
        }

        return $chosenDesign;

    }
}

class TestPromotion
{
    public function makeTestForPromotion(int $promoId, int $iteration = 1000)
    {
        $visitsByDesign = [];
        $myClass = new MyClass($promoId);
        echo "\n Promotion name - " . $myClass->getName() . "\n";
        for ($i = 1; $i <= $iteration; $i++) {
            $design = $myClass->getDesign();
            if (isset($visitsByDesign[$design['designId']])) {
                $visitsByDesign[$design['designId']]['count']++;
            } else {
                $visitsByDesign[$design['designId']] = ['name' => $design['designName'], 'count' => 1];
            }
        }
        foreach ($visitsByDesign as $item) {
            printf("%s - %s(%s)\n", $item['name'], $item['count'], round(($item['count']/$iteration)*100, 1)) ;
        }
    }
}
$test = new TestPromotion();
foreach (range(1, 3) as $promoId) {
    $test->makeTestForPromotion($promoId);
}