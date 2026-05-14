<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Services\MrnGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MrnGeneratorTest extends TestCase
{
    use RefreshDatabase;

    private function newCustomer(array $overrides = []): Customer
    {
        return Customer::create(array_merge([
            'name' => 'Test Patient',
            'sex' => 'M',
            'province_id' => 1,
            'district_id' => 1,
            'commune_id' => 1,
            'village_id' => 1,
        ], $overrides));
    }

    public function test_mrn_format_is_lab_year_six_digits(): void
    {
        $customer = $this->newCustomer();

        $year = date('Y');
        $this->assertMatchesRegularExpression(
            "/^LAB-{$year}-\d{6}$/",
            $customer->mrn,
            'MRN should look like LAB-YYYY-NNNNNN',
        );
    }

    public function test_sequential_customers_get_sequential_mrns(): void
    {
        $a = $this->newCustomer();
        $b = $this->newCustomer();
        $c = $this->newCustomer();

        $extractSeq = fn (Customer $cust) => (int) substr($cust->mrn, -6);

        $this->assertSame(1, $extractSeq($a));
        $this->assertSame(2, $extractSeq($b));
        $this->assertSame(3, $extractSeq($c));
    }

    public function test_manually_supplied_mrn_is_respected(): void
    {
        $customer = $this->newCustomer(['mrn' => 'LEGACY-001']);

        $this->assertSame('LEGACY-001', $customer->mrn,
            'When the caller pre-sets mrn, the generator should not overwrite it.');
    }

    public function test_generator_continues_from_highest_existing_mrn(): void
    {
        $this->newCustomer(['mrn' => 'LAB-'.date('Y').'-000099']);

        $next = app(MrnGenerator::class)->nextFor();

        $this->assertSame('LAB-'.date('Y').'-000100', $next,
            'Generator should resume at the next integer after the highest existing MRN for the current year.');
    }
}
