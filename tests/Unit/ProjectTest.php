<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_projects()
    {
        $token = $this->authenticatedUser();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/projects');

        $response->assertStatus(200);
    }
    protected function authenticatedUser()
    {
        $body = [
            'username' => 'mnisij64@gmail.com',
            'password' => 'password',
            'grant_type' => config('services.passport.grant_type'),
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'scope' => '*'
        ];
        $response =  $this->json('POST','/oauth/token',$body,['Accept' => 'application/json']);
        $response = json_decode($response->content());
        return $response->access_token;
    }
}
