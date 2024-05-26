<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignatureTest extends TestCase
{
    /**
     * Signature feature test
     */

    public function test_donnot_creating_a_new_signature_without_a_required_field(): void
    {
        $data = [
            "description" => "mercado livre",
            "amount" => "20",
            "status_invoice" => "aguardando",
            "due_date" => "2024-05-05 11:59:49"
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', 'api/invoice/insert', $data);

        $response->assertStatus(400);
    }

    public function test_the_signature_returns_valid_data_in_getall_route_in_getaal_route(): void
    {
        $response = $this->get('api/signature/getall');

        $response->assertStatus(200);
    }

    public function test_returns_one_specific_signature_in_get_route(): void
    {
        $response = $this->get('api/signature/get/1');

        $response->assertStatus(200);
    }

    public function test_donnot_bring_signature_with_an_invalid_id(): void
    {
        $response = $this->get('api/invoice/get/xpto');

        $response->assertStatus(400);
    }

    public function test_donnot_bring_signature_with_nonexistent_id(): void
    {
        $response = $this->get('api/invoice/get/10000000');

        $response->assertStatus(406);
    }

    public function test_sending_a_nonexistent_id_need_to_be_warned_in_delete_route(): void
    {
        $response = $this->get('api/invoice/get/10000000');

        $response->assertStatus(406);
    }

    public function test_refuse_deletation_with_an_invalid_id(): void
    {
        $response = $this->get('api/invoice/get/xpto');

        $response->assertStatus(400);
    }
}
