<?php

namespace App\Metrics\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

abstract class Metric
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    public $name;

    /**
     * Calculate the metric's value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function resolve(Request $request)
    {
        $resolver = function () use ($request) {
            return $this->calculate($request);
        };

        if ($this->cacheFor()) {
            return Cache::remember(
                $this->getCacheKey($request),
                $this->cacheFor(),
                $resolver
            );
        }

        return $resolver();
    }

    /**
     * Get the appropriate cache key for the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function getCacheKey(Request $request)
    {
        return sprintf(
            'nova.metric.%s.%s.%s.%s',
            $this->uriKey(),
            $request->input('range', 'no-range'),
            $request->input('timezone', 'no-timezone'),
            $request->input('twelveHourTime', 'no-12-hour-time')
        );
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        //
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return Str::slug($this->name());
    }

    /**
     * Prepare the metric for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'class' => get_class($this),
            'name' => $this->name(),
            'uriKey' => $this->uriKey(),
        ]);
    }
}
