<?php
namespace App\Contract;

use App\Model\TvSeriesListElement;

interface TvSeriesRepoInterface
{
    public function nextTvSeries($date, $title = null) :?TvSeriesListElement;
}