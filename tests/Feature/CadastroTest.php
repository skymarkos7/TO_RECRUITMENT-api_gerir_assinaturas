<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * User feature test
     */

    public function test_donnot_creating_a_new_user_without_a_required_field(): void
    {
        $data = [
            // "codigo" => "XYYYTT", // sending without code
            "nome" => "juca gomes",
            "email" => "email@noformatovalido.com",
            "telefone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('POST', 'api/user/insert', $data);

        $response->assertStatus(400);
    }

    public function test_donnot_creating_a_user_that_already_exists_in_database(): void
    {
        $data = [
            "codigo" => "XYBBTT", // sending without code
            "nome" => "ana maria",
            "email" => "ana@hotmail.com",
            "telefone" => "82954666"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('POST', 'api/user/insert', $data); // Save the first

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', 'api/user/insert', $data); // Try save the same again

        $response->assertStatus(406);
    }

    public function test_the_user_returns_valid_data_in_getall_route_in_getaal_route(): void
    {
        $response = $this->get('api/user/getall');

        $response->assertStatus(200);
    }

    public function test_the_user_returns_one_specific_user_in_get_route(): void
    {
        $response = $this->get('api/user/get/1');

        $response->assertStatus(200);
    }

    public function test_sending_an_invalid_id_need_be_refused_in_get_route(): void
    {
        $response = $this->get('api/user/get/xpto');

        $response->assertStatus(400);
    }

    public function test_sending_an_nonexistent_id_need_to_be_warned_in_get_route(): void
    {
        $response = $this->get('api/user/get/10000000');

        $response->assertStatus(406);
    }

    public function test_sending_an_nonexistent_id_need_to_be_warned_in_update_route(): void
    {
        $data = [
            "codigo" => "XYYYTT",
            "nome" => "juca gomes",
            "email" => "deltan@semLanhou.com",
            "telefone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('PUT', 'api/user/update/10000000', $data);

        $response->assertStatus(406);
    }

    public function test_sending_an_invalid_id_need_be_refused_in_update_route(): void
    {
        $data = [
            "codigo" => "XYYYTT",
            "nome" => "juca gomes",
            "email" => "deltan@semLanhou.com",
            "telefone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('PUT', 'api/user/update/xpto', $data);

        $response->assertStatus(400);
    }

    public function test_sending_any_field_required_empty_will_be_asked_in_update_route(): void
    {
        $data = [
            "codigo" => "XYYYTT",
            // "nome" => "juca gomes",     // EMPTY FIELD
            "email" => "deltan@semLanhou.com",
            "telefone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('PUT', 'api/user/update/1', $data);

        $response->assertStatus(400);
    }

    public function test_sending_invalid_email_will_be_asked_to_correct_in_update_route(): void
    {
        $data = [
            "codigo" => "XYYYTT",
            "nome" => "juca gomes",
            "email" => "emailemumformatoinvalido",
            "telefone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('PUT', 'api/user/update/1', $data);

        $response->assertStatus(422);
    }

    public function test_sending_correct_data_the_user_is_updated_successfully_in_update_route(): void
    {
        $data = [
            "codigo" => "XYYYTT",
            "nome" => "juca gomes",
            "email" => "email@noformatovalido.com",
            "telefone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('PUT', 'api/user/update/1', $data);

        $response->assertStatus(201);
    }

    public function test_sending_a_nonexistent_id_need_to_be_warned_in_delete_route(): void
    {
        $response = $this->get('api/user/get/10000000');

        $response->assertStatus(406);
    }

    public function test_sending_an_invalid_id_need_be_refused_in_delete_route(): void
    {
        $response = $this->get('api/user/get/xpto');

        $response->assertStatus(400);
    }
}
