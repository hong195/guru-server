<?php

namespace Tests\Unit;

use App\Services\Interfaces\OAuthInterface;
use App\Services\OAuth\FakeOauthService;
use PHPUnit\Framework\TestCase;

class OAuthInterfaceTest extends TestCase
{
    private OAuthInterface $oAuth;

    public function __construct()
    {
        parent::__construct();
        $this->oAuth = new FakeOauthService();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $code = 'test_code-343434_2dfee';

        $this->oAuth->authorize($code);

        $this->assertNotEmpty($this->oAuth->getAccessToken());
        $this->assertNotEmpty($this->oAuth->getRefreshToken());
    }
}
