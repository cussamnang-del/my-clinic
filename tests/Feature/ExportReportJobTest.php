<?php

namespace Tests\Feature;

use App\Jobs\ExportReportJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExportReportJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_streams_header_and_rows_to_csv_on_the_target_disk(): void
    {
        Storage::fake('local');

        $job = new ExportReportJob(
            headers: ['id', 'name', 'sex'],
            disk: 'local',
            path: 'exports/customers.csv',
            rowGenerator: fn () => [
                ['id' => 1, 'name' => 'Alice', 'sex' => 'F'],
                ['id' => 2, 'name' => 'Bob', 'sex' => 'M'],
            ],
        );

        $job->handle();

        Storage::disk('local')->assertExists('exports/customers.csv');
        $csv = Storage::disk('local')->get('exports/customers.csv');

        $this->assertStringContainsString('id,name,sex', $csv);
        $this->assertStringContainsString('1,Alice,F', $csv);
        $this->assertStringContainsString('2,Bob,M', $csv);
    }

    public function test_missing_keys_are_serialised_as_empty_strings(): void
    {
        Storage::fake('local');

        $job = new ExportReportJob(
            headers: ['id', 'name', 'phone'],
            disk: 'local',
            path: 'exports/partial.csv',
            rowGenerator: fn () => [
                ['id' => 1, 'name' => 'Alice'], // phone missing
            ],
        );

        $job->handle();

        $csv = Storage::disk('local')->get('exports/partial.csv');
        $this->assertStringContainsString("1,Alice,\n", $csv);
    }
}
