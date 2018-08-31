<?php

namespace App\Metrics;

use App\CompilationLog;
use Cake\Chronos\Chronos;
use Illuminate\Http\Request;
use App\Metrics\Core\Trend;

class CompilationsPerDay extends Trend
{
    /**
     * Format the aggregate result date into a proper string.
     *
     * @param  string  $result
     * @param  string  $unit
     * @param  bool  $twelveHourTime
     * @return string
     */
    protected function formatAggregateResultDate($result, $unit, $twelveHourTime)
    {
        switch ($unit) {
            case 'month':
                return $this->formatAggregateMonthDate($result);

            case 'week':
                return $this->formatAggregateWeekDate($result);

            case 'day':
                return with(Chronos::createFromFormat('Y-m-d', $result), function ($date) {
                    return $date->format('j').' de '.__($date->format('F')).' de '.$date->format('Y');
                });

            case 'hour':
                return with(Chronos::createFromFormat('Y-m-d H:00', $result), function ($date) use ($twelveHourTime) {
                    return $twelveHourTime
                        ? $date->format('j').' de '.__($date->format('F')).' - '.$date->format('g:00 A')
                        : $date->format('j').' de '.__($date->format('F')).' - '.$date->format('G:00');
                });

            case 'minute':
                return with(Chronos::createFromFormat('Y-m-d H:i:00', $result), function ($date) use ($twelveHourTime) {
                    return $twelveHourTime
                        ? $date->format('j').' de '.__($date->format('F')).' - '.$date->format('g:i A')
                        : $date->format('j').' de '.__($date->format('F')).' - '.$date->format('G:i');
                });
        }
    }

    /**
     * Format the possible aggregate result date into a proper string.
     *
     * @param  \Cake\Chronos\Chronos  $date
     * @param  string  $unit
     * @param  bool  $twelveHourTime
     * @return string
     */
    protected function formatPossibleAggregateResultDate(Chronos $date, $unit, $twelveHourTime)
    {
        switch ($unit) {
            case 'month':
                return __($date->format('F')).' '.$date->format('Y');

            case 'week':
                return __($date->startOfWeek()->format('F')).' '.$date->startOfWeek()->format('j').' - '.
                    __($date->endOfWeek()->format('F')).' '.$date->endOfWeek()->format('j');

            case 'day':
                return $date->format('j').' de '.__($date->format('F')).', '.$date->format('Y');

            case 'hour':
                return $twelveHourTime
                    ? $date->format('j').' de '.__($date->format('F')).' - '.$date->format('g:00 A')
                    : $date->format('j').' de '.__($date->format('F')).' - '.$date->format('G:00');

            case 'minute':
                return $twelveHourTime
                    ? $date->format('j').' de '.__($date->format('F')).' - '.$date->format('g:i A')
                    : $date->format('j').' de '.__($date->format('F')).' - '.$date->format('G:i');
        }
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays($request, CompilationLog::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            90 => '90 Days',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'compilations-per-day';
    }
}