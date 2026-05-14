<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ReferenceRange;
use Illuminate\Database\Seeder;

/**
 * Seeds a starter set of reference ranges based on the standard
 * Complete Blood Count (CBC) panel.
 *
 * Values are illustrative laboratory-textbook defaults intended to
 * exercise the lookup service end-to-end; clinical sites MUST
 * review and replace them against their own validated reference
 * intervals before going live (ISO 15189:2022 §7.3.7.2 c).
 *
 * The seeder is idempotent: it matches an existing analyte by item
 * name and only creates ranges that don't already exist.
 */
class ReferenceRangeSeeder extends Seeder
{
    public function run(): void
    {
        // Map of "analyte name (case-insensitive contains match)" → range rows.
        $catalogue = [
            'haemoglobin' => [
                ['M', null, null, 13.5, 17.5, 7.0, 21.0, 'g/dL'],
                ['F', null, null, 12.0, 15.5, 7.0, 21.0, 'g/dL'],
            ],
            'hemoglobin' => [
                ['M', null, null, 13.5, 17.5, 7.0, 21.0, 'g/dL'],
                ['F', null, null, 12.0, 15.5, 7.0, 21.0, 'g/dL'],
            ],
            'wbc' => [
                [null, null, null, 4.0, 11.0, 1.0, 30.0, 'x10^9/L'],
            ],
            'platelet' => [
                [null, null, null, 150.0, 450.0, 20.0, 1000.0, 'x10^9/L'],
            ],
            'glucose' => [
                [null, null, null, 70.0, 110.0, 40.0, 500.0, 'mg/dL'],
            ],
            'creatinine' => [
                ['M', null, null, 0.7, 1.3, null, 10.0, 'mg/dL'],
                ['F', null, null, 0.6, 1.1, null, 10.0, 'mg/dL'],
            ],
            'potassium' => [
                [null, null, null, 3.5, 5.1, 2.5, 6.5, 'mmol/L'],
            ],
            'sodium' => [
                [null, null, null, 135.0, 145.0, 120.0, 160.0, 'mmol/L'],
            ],
        ];

        foreach ($catalogue as $needle => $rows) {
            $items = Item::query()
                ->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($needle).'%'])
                ->get();

            foreach ($items as $item) {
                foreach ($rows as [$sex, $ageMin, $ageMax, $low, $high, $cLow, $cHigh, $unit]) {
                    ReferenceRange::firstOrCreate(
                        [
                            'item_id' => $item->id,
                            'sex' => $sex,
                            'age_min_days' => $ageMin,
                            'age_max_days' => $ageMax,
                        ],
                        [
                            'low_value' => $low,
                            'high_value' => $high,
                            'critical_low' => $cLow,
                            'critical_high' => $cHigh,
                            'unit' => $unit,
                            'source' => 'starter pack (Phase 2 seed)',
                        ],
                    );
                }
            }
        }
    }
}
