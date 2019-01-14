<?php

namespace App\Console\Commands;

use Closure;
use Swap\Swap;
use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

abstract class DataConverter extends Command
{
    protected $hasher;

    protected $faker;

    protected $swap;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        HasherContract $hasher,
        Swap $swap
    ) {
        parent::__construct();

        // $this->faker = Faker::create();

        $this->swap = $swap;

        $this->hasher = $hasher;
    }

    public function conn()
    {
        return DB::connection('tmp_sqlsrv');
    }

    protected function convertToEUR($from, $amount)
    {
        if ($from == 'EUR') {
            return $amount;
        }
        return $amount / $this->swap->latest('EUR/' . $from)->getValue();
    }

    protected function convert($data, $file, Closure $callback, $progress = true)
    {
        $resource = is_resource($file);

        $bar = $this->output->createProgressBar(count($data));

        if ($progress) {
            $bar->start();
        }

        if (!$resource) {
            $file = fopen($file, 'c+');
        }

        collect($data)->each(function ($row) use ($file, $bar, $callback, $progress) {
            if ($progress) {
                $bar->advance();
            }

            fputcsv($file, $callback($row), ';', '\'');
        });

        if (!$resource) {
            fclose($file);
        }

        if ($progress) {
            $bar->finish();
        }
    }

    protected function convertInChunks($file, $amount, $table, Closure $query, Closure $callback)
    {
        $count = $this->conn()->select('
            SELECT
                COUNT(*) as count
            FROM ' . $table . '
        ')[0]->count;

        $file = fopen($file, 'c+');

        $bar = $this->output->createProgressBar(ceil($count / $amount));

        $bar->start();

        collect(
            range(0, ceil($count / $amount))
        )->each(function ($number) use ($bar, $file, $amount, $query, $callback) {
            $bar->advance();

            $this->convert(
                $query($amount * $number, $amount),
                $file,
                $callback
            );
        });

        $bar->finish();

        fclose($file);
    }
}
