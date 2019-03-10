<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\Exceptions\AuthException;
use App\Entities\Users\User;


class JwtMiddleware
{
    /**
     *  User user
     *
     * @var App\Entities\Users\User
     */
    protected $user;

    /**
     * Create a new middleware instance.
     *
     * @param  App\Entities\Users\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (property_exists($request, 'user') && !empty($request->user['id'])) {
            return $next($request);
        }

        $token = $request->get('token', $request->bearerToken());

        if (!$token) {
            throw new AuthException("Token not provided");
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            throw new ExpiredException("Provided token has been expired");
        } catch (\Exception $e) {
            throw new AuthException("Seems invalid token provided");
        }

        $request->user = $this->user->find($credentials->sub);

        return $next($request);
    }
}