<?php

namespace Tests\Feature;

use App\Services\Activation\EnvatoPluginActivation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnavatoPluginActivationTest extends TestCase
{
    private mixed $activationService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->activationService = app()->make(EnvatoPluginActivation::class);
        parent::__construct($name, $data, $dataName);
    }

    public function test_it_creates_record_of_activated_plugin()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
