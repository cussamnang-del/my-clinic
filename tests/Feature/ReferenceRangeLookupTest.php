<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemGroup;
use App\Models\ItemType;
use App\Models\ReferenceRange;
use App\Services\ReferenceRangeLookup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ReferenceRangeLookupTest extends TestCase
{
    use RefreshDatabase;

    private Item $item;

    protected function setUp(): void
    {
        parent::setUp();

        $group = ItemGroup::create(['name' => 'Haematology']);
        $type = ItemType::create(['name' => 'CBC', 'item_group_id' => $group->id]);
        $this->item = Item::create([
            'item_name' => 'Haemoglobin',
            'item_group_id' => $group->id,
            'item_type_id' => $type->id,
        ]);
    }

    public function test_sex_specific_range_beats_catch_all(): void
    {
        // Catch-all
        ReferenceRange::create([
            'item_id' => $this->item->id,
            'sex' => null,
            'low_value' => 1, 'high_value' => 100,
            'unit' => 'g/dL',
        ]);
        // Male-specific
        ReferenceRange::create([
            'item_id' => $this->item->id,
            'sex' => 'M',
            'low_value' => 13.5, 'high_value' => 17.5,
            'unit' => 'g/dL',
        ]);

        $hit = app(ReferenceRangeLookup::class)->findFor($this->item->id, 'M', null);

        $this->assertNotNull($hit);
        $this->assertSame('M', $hit->sex);
        $this->assertEqualsWithDelta(13.5, (float) $hit->low_value, 0.001);
    }

    public function test_flag_classifies_values_against_thresholds(): void
    {
        $range = ReferenceRange::create([
            'item_id' => $this->item->id,
            'low_value' => 12.0,
            'high_value' => 16.0,
            'critical_low' => 7.0,
            'critical_high' => 21.0,
            'unit' => 'g/dL',
        ]);

        $lookup = app(ReferenceRangeLookup::class);

        $this->assertSame('critical_low', $lookup->flagValue($range, 6.0));
        $this->assertSame('low', $lookup->flagValue($range, 10.0));
        $this->assertSame('normal', $lookup->flagValue($range, 14.0));
        $this->assertSame('high', $lookup->flagValue($range, 18.0));
        $this->assertSame('critical_high', $lookup->flagValue($range, 25.0));
        $this->assertNull($lookup->flagValue($range, 'not-a-number'));
        $this->assertNull($lookup->flagValue(null, 14.0));
    }

    public function test_age_band_filters_correctly(): void
    {
        // Neonatal range (0–28 days)
        ReferenceRange::create([
            'item_id' => $this->item->id,
            'age_min_days' => 0,
            'age_max_days' => 28,
            'low_value' => 14.0, 'high_value' => 24.0,
        ]);
        // Adult range
        ReferenceRange::create([
            'item_id' => $this->item->id,
            'age_min_days' => 365 * 18,
            'age_max_days' => null,
            'low_value' => 12.0, 'high_value' => 17.0,
        ]);

        $lookup = app(ReferenceRangeLookup::class);

        $infant = $lookup->findFor($this->item->id, null, Carbon::now()->subDays(10));
        $this->assertNotNull($infant);
        $this->assertEqualsWithDelta(14.0, (float) $infant->low_value, 0.001);

        $adult = $lookup->findFor($this->item->id, null, Carbon::now()->subYears(30));
        $this->assertNotNull($adult);
        $this->assertEqualsWithDelta(12.0, (float) $adult->low_value, 0.001);
    }
}
