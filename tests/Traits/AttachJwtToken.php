<?php
namespace Tests\Traits;

trait AttachJwtToken
{
    protected function getJwtToken()
    {
        if(!defined("LOGGED_USER_JWT_TOKEN")) {
            $user = factory(\App\Entities\Users\User::class)->create();
            $this->loggedInUser = $this->call("POST", "api/v1/auth/tokens", [
                'email' => $user->email,
                'password' => '123456'
            ])->getOriginalContent();

            define('LOGGED_USER_JWT_TOKEN', $this->loggedInUser['token'] );
        }

        return LOGGED_USER_JWT_TOKEN;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string $content
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        if ($this->needsToken($uri)) {
            $server = $this->attachToken($server);
        }

        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    protected function needsToken($url)
    {
        return !in_array(
            $url, [
                'api/v1/auth/tokens'
            ]
        );
    }

   /**
    * @param array $server
    * @return string
    */
    protected function attachToken(array $server)
    {
       return array_merge($server, $this->transformHeadersToServerVars([
           'Authorization' => 'Bearer ' . $this->getJwtToken(),
       ]));
    }

}
