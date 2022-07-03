<?php

namespace App\Console\Commands\Database;

use function getAllNovaResourceTables;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Katyusha\Framework\Eloquent\Model;
use function str_replace;

class GenerateAllGlobalColumns extends Command
{
    protected $signature = 'db:generate-columns';
    protected $description = 'Create a new transformer class';

    public function handle(): void
    {
        $tables = getAllNovaResourceTables();

        foreach ($tables as $tableName) {
            $columnExists = false;

            try {
                DB::statement("alter table ${tableName} add numeric_id bigint;");
                $columnExists = false;
            } catch (QueryException $queryException) {
                if (! Str::contains($queryException->getMessage(), '42P07')) {
                    $columnExists = false;
                }
            }

            $nullIds = DB::table($tableName)->whereNull('numeric_id')->get()->pluck('id');
            foreach ($nullIds as $uuid) {
                DB::table($tableName)->where('id', $uuid)->update(['numeric_id' => Model::createUniqueNumericId()]);
            }

            if ($columnExists) {
                $underscoreTableName = str_replace('.', '_', $tableName);
                DB::statement("create unique index ${$underscoreTableName} numeric_id_uindex on ${tableName} (numeric_id);");
            }
        }

        $this->info('Mandatory columns created.');
    }
}
