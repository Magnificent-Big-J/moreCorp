<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $response = $this->authorizeUser($request->email, $request->password);
            $body = json_decode($response->getBody());
            $body->user = User::where('email', $request->email)->get();

            return response()->json($body);
        } catch (BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid request. Please enter a username and password.', $e->getCode());
            } elseif ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server', $e->getCode());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json('Successfully registered',200);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * @param string $email
     * @param string $password
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function authorizeUser(string  $email, string  $password)
    {
        $http = new Client();

       return  $http->post(config('services.passport.login_end_point'), [
            'form_params' => [
                'grant_type' => config('services.passport.grant_type'),
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'username' => $email,
                'password' => $password,
            ]
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token) {
           $token->delete();
        });

        return response()->json('Successfully logged out',200);
    }
}
