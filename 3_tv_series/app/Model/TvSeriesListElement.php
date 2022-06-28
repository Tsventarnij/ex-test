<?php
namespace App\Model;

class TvSeriesListElement
{
    public $title;
    public $channel;
    public $time;
    public $weekDay;
    public $date;

    public function __construct($title, $channel, $time, $weekDay, $date)
    {
        $this->title = $title;
        $this->channel = $channel;
        $this->time = $time;
        $this->weekDay = $weekDay;
        $this->date = $date;
    }

}