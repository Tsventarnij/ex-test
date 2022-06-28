<?php
namespace App\Service;

use App\Contract\TvSeriesRepoInterface;

class TvProgrammes
{
    /**
     * @var TvSeriesRepoInterface
     */
    private $tvSeriesRepo;

    public function __construct(TvSeriesRepoInterface $tvSeriesRepo)
    {
        $this->tvSeriesRepo = $tvSeriesRepo;
    }

    public function getNext($date, $title = null)
    {
        return $this->tvSeriesRepo->nextTvSeries($date, $title) ?? [];
    }
}