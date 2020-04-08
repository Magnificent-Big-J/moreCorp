<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    protected $headers = [];
    protected $scopes = [];
    /**
     * A basic unit test example.
     * @test
     * @return void
     */
    public function register()
    {
        $this->headers['Accept'] = 'application/json';
        $num = rand(1000,10000);
        $payload = ['name' => 'Nick Jane', 'email'=> "nick.Jones{$num}@example.com",'password' => 'password'];
        $response = $this->json('POST', '/api/register', $payload);

        $response
            ->assertStatus(200);
    }

    /**
     *
     */
    public function login()
    {

        $body = [
            'username' => 'mnisij64@gmail.com',
            'password' => 'password',
            'grant_type' => config('services.passport.grant_type'),
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'scope' => '*'
        ];
        $this->json('POST','/oauth/token',$body,['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token']);
    }


}
