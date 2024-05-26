<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * Invoice feature test
     */

    public function test_the_invoice_returns_valid_data_in_getall_route_in_getaal_route(): void
    {
        $response = $this->get('api/invoice/getall');

        $response->assertStatus(200);
    }

    public function test_returns_one_specific_invoice_in_get_route(): void
    {
        $response = $this->get('api/invoice/get/1');

        $response->assertStatus(200);
    }

    public function test_donnot_bring_invoice_with_an_invalid_id(): void
    {
        $response = $this->get('api/invoice/get/xpto');

        $response->assertStatus(400);
    }

    public function test_donnot_bring_invoice_with_nonexistent_id(): void
    {
        $response = $this->get('api/invoice/get/10000000');

        $response->assertStatus(406);
    }

    public function test_donnot_bring_invoice_sending_a_nonexistent_id(): void
    {
        $response = $this->get('api/invoice/get/10000000');

        $response->assertStatus(406);
    }

    public function test_refuse_invoice_deletation_with_an_invalid_id(): void
    {
        $response = $this->get('api/invoice/get/xpto');

        $response->assertStatus(400);
    }
}
