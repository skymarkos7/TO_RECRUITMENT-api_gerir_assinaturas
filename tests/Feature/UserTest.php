<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * User feature test
     */

    use DatabaseTransactions;

    public function test_donnot_creating_a_new_user_without_a_required_field(): void
    {
        $data = [
            // "name" => "Marcos Lourenço", // sending without name
            "mail" => "marquinhos@host.com",
            "phone" => "(82) 99690-9210"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('POST', 'api/user/insert', $data);

        $response->assertStatus(422);
    }

    public function test_donnot_creating_a_user_that_already_exists_in_database(): void
    {
        $data = [
            "name" => "ana maria",
            "mail" => "ana@hotmail.com",
            "phone" => "(82) 99690-9200"
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

    public function test_sending_an_nonexistent_id_return_warned(): void
    {
        $response = $this->get('api/user/get/10000000');

        $response->assertStatus(406);
    }

    public function test_sending_an_nonexistent_id_need_to_be_warned_in_update_route(): void
    {
        $data = [
            "name" => "juca gomes",
            "mail" => "deltan@semLanhou.com",
            "phone" => "(82) 99691-9322"
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
            "name" => "juca gomes",
            "mail" => "deltan@semLanhou.com",
            "phone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('PUT', 'api/user/update/xpto', $data);

        $response->assertStatus(400);
    }

    public function test_sending_invalid_mail_will_be_asked_to_correct_in_update_route(): void
    {
        $data = [
            "codigo" => "XYYYTT",
            "name" => "juca gomes",
            "mail" => "mailemumformatoinvalido",
            "phone" => "82954655"
        ];

        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
            ])->json('PUT', 'api/user/update/1', $data);

        $response->assertStatus(422);
    }

    public function test_sending_correct_data_the_user_is_updated_successfully_in_update_route(): void
    {
        $data = [
            "name" => "juca gomes",
            "mail" => "mail@noformatovalido.com",
            "phone" => "(82) 99546-5544"
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
