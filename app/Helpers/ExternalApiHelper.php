<?php


namespace App\Helpers;


class ExternalApiHelper
{
    private $_foo;

    public function __construct($foo)
    {
        $this->_foo = $foo;
    }

    public function foo()
    {
        return $this->_foo;
    }

    public static function bar()
    {
        return app(ExternalApiHelper::class)->foo();
    }

    public static function setFoo($foo)
    {
        $externalApi = app(ExternalApiHelper::class);
        $externalApi->_foo = $foo;

        return $externalApi;
    }
}
