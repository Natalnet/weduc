<?php

namespace App\Metrics;

use App\CompilationLog;
use Illuminate\Http\Request;
use App\Metrics\Core\Partition;
use Natalnet\Relex\Exceptions\InvalidCharacterException;
use Natalnet\Relex\Exceptions\SymbolNotDefinedException;
use Natalnet\Relex\Exceptions\SymbolRedeclaredException;
use Natalnet\Relex\Exceptions\TypeMismatchException;
use Natalnet\Relex\Exceptions\UnexpectedTokenException;

class CompilationErrors extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, CompilationLog::where('is_successful', 1), 'exception')
            ->label(function ($value) {
                switch ($value) {
                    case null:
                        return 'None';
                    case InvalidCharacterException::class:
                        return 'Caractere inválido';
                    case SymbolNotDefinedException::class:
                        return 'Símbolo não definido';
                    case TypeMismatchException::class:
                        return 'Tipos incompatíveis';
                    case UnexpectedTokenException::class:
                        return 'Token não esperado';
                    case SymbolRedeclaredException::class:
                        return 'Símbolo redeclarado';
                    default:
                        return ucfirst($value);
                }
            });
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
        return 'compilation-errors';
    }
}
