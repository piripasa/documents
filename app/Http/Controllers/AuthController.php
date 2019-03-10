<?php

namespace App\Http\Controllers;

use App\Entities\Users\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Users\UserRepository;
use App\Exceptions\AuthException;


class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * The repository instance.
     *
     * @var \App\Repositories\Users\UserRepository
     */
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Repositories\Users\UserRepository  $repository
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(UserRepository $repository,  Request $request) {
        $this->repository = $repository;
        $this->request = $request;
    }

    /**
     * Create a new token.
     *
     * @param  $user
     * @return string
     */
    private function jwt($user) {
        $payload = [
            'iss' => env('JWT_SECRET'), // Issuer of the token
            'sub' => $user['id'], // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 24*60*60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Login a user and return the token if the provided credentials are correct.
     *
     * @param  \App\Entities\User   $user
     * @return mixed
     */
    public function login(User $user)
    {
        $user = $this->repository->findByField(
            'email',
            $this->request->input('email')
        )['data'][0] ?? array();

        if(empty($user)) {
            throw new AuthException("These credentials do not match our records.");
        }

        if(app('hash')->check($this->request->input('password'), $user['password'])) {
            return response()->json([
                'token' => $this->jwt($user),
                'user' => $user
            ]);
        }

        throw new AuthException("These credentials do not match our records.");

    }
}

