<?php
namespace Tests;

use Laravel\Lumen\Testing\TestCase as TCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

define('LUMEN_START', microtime(true));

abstract class TestCase extends TCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {        
        //putenv('DB_CONNECTION=testing');    
        return require __DIR__.'/../bootstrap/app.php';
    }
}
