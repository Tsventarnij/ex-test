<?php
namespace App\Repository;

use App\Contract\TvSeriesRepoInterface;
use App\Model\TvSeriesListElement;
use mysqli;

class TvSeriesMysqlRepo implements TvSeriesRepoInterface
{
    public $con = null;

    public function __construct()
    {
        $this->con = new mysqli(
            $_ENV['MYSQL_DB_HOST'] . ':' . $_ENV['MYSQL_DB_PORT'],
            $_ENV['MYSQL_DB_USERNAME'],
            $_ENV['MYSQL_DB_PASSWORD'],
            $_ENV['MYSQL_DB_DATABASE']
        );
        if ($this->con->connect_error) {
            throw new \Exception('Fail ' . $this->con->connect_error);
        }
    }

    public function nextTvSeries($date, $title = null): ?TvSeriesListElement
    {
        $timestamp = strtotime($date);
        $year = date('Y', $timestamp);
        $weekOfYear = intval(date('W', $timestamp));
        $dayOfWeek = intval(date('N', $timestamp));
        $time = date('H:i:s', $timestamp);
        $queryString = '
            SELECT tv_series.title as title, 
                tv_series.channel as channel, 
                tv_series.gender as gender, 
                tv_series_intervals.week_day as week_day, 
                tv_series_intervals.show_time as time,
                (CASE 
                    WHEN week_day > ' . $dayOfWeek . ' THEN STR_TO_DATE(CONCAT("' . $year . ' ' . $weekOfYear . ' ", week_day, " ", show_time), "%X %V %W %k:%i:%s")
                    WHEN week_day = ' . $dayOfWeek . ' && show_time >= "' . $time . '" THEN STR_TO_DATE(CONCAT("' . $year . ' ' . $weekOfYear . ' ", week_day, " ", show_time), "%X %V %W %k:%i:%s")
                    ELSE STR_TO_DATE(CONCAT("' . $year . ' ' . ($weekOfYear + 1) . ' ", week_day, " ", show_time), "%X %V %W %k:%i:%s")
                END) as date
            FROM tv_series
            RIGHT JOIN tv_series_intervals on tv_series.id = tv_series_intervals.id_tv_series' .
            (empty($title) ? '' : " WHERE title LIKE '%$title%'")
            . ' ORDER BY date LIMIT 1;';
        $result = $this->con->query($queryString);
        if ($result) {
            $element = $result->fetch_all(MYSQLI_ASSOC)[0];
            return new TvSeriesListElement(
                $element['title'],
                $element['channel'],
                substr($element['time'], 0,5),
                $element['week_day'],
                substr($element['date'], 0, 10)
            );
        }
        return null;
    }
}