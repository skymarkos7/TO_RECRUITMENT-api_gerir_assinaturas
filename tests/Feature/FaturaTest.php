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

    public function test_donnot_creating_a_new_invoice_without_a_required_field(): void
    {
        $data = [
            // "user" => "XYYYTT", // sending without code
            "signature" => "1",
            "description" => "mercado livre",
            "due_date" => "2024-05-05 11:59:49",
            "amount" => "20",
            "status" => "pendente"

        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', 'api/user/insert', $data);

        $response->assertStatus(400);
    }

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
