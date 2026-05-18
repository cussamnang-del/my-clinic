<?php

namespace Tests\Feature;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\ItemResource;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_resource_exposes_only_whitelisted_columns(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        Auth::login(User::factory()->create());

        $customer = Customer::create([
            'name' => 'Alice',
            'sex' => 'F',
            'phone_no' => '0123456789',
            'register_date' => now(),
            'province_id' => 0,
            'district_id' => 0,
            'commune_id' => 0,
            'village_id' => 0,
        ]);

        $array = CustomerResource::make($customer)->toArray(Request::create('/'));

        $this->assertSame([
            'id', 'mrn', 'customer_code', 'name', 'sex', 'age', 'dob',
            'phone_no', 'nationality', 'register_date', 'address',
            'created_at', 'updated_at',
        ], array_keys($array));
    }

    public function test_document_resource_includes_customer_when_loaded(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        Auth::login(User::factory()->create());

        $customer = Customer::create([
            'name' => 'Patient',
            'sex' => 'M',
            'phone_no' => '0123456789',
            'register_date' => now(),
            'province_id' => 0,
            'district_id' => 0,
            'commune_id' => 0,
            'village_id' => 0,
        ]);

        $doc = Document::create([
            'customer_id' => $customer->id,
            'user_id' => Auth::id(),
            'visit_date' => '2026-05-14 10:00:00',
            'status' => 1,
        ]);

        $array = DocumentResource::make($doc->load('customer'))->toArray(Request::create('/'));

        $this->assertSame($customer->id, $array['customer']['id']);
        $this->assertSame('Patient', $array['customer']['name']);
    }

    public function test_item_resource_exposes_only_whitelisted_columns(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        Auth::login(User::factory()->create());

        $item = Item::create([
            'item_name' => 'Glucose',
            'uvn' => 'mg/dL',
            'item_group_id' => 0,
            'item_type_id' => 0,
        ]);

        $array = ItemResource::make($item)->toArray(Request::create('/'));

        $this->assertSame(
            ['id', 'item_name', 'uvn', 'item_type_id', 'item_group_id'],
            array_keys($array),
        );
        $this->assertSame('Glucose', $array['item_name']);
    }
}
