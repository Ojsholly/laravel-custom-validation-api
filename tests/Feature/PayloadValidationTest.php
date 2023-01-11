<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayloadValidationTest extends TestCase
{
    /**
     * Test that the endpoint returns the correct response for valid data
     *
     * @return void
     */
    public function test_valid_data_returns_correct_response(): void
    {
        $data = [
            'first_name' => [
                'value' => 'John',
                'rules' => 'alpha|required'
            ],
            'last_name' => [
                'value' => 'Doe',
                'rules' => 'alpha|required'
            ],
            'email' => [
                'value' => 'example@example.com',
                'rules' => 'email'
            ],
            'phone' => [
                'value' => '08175020329',
                'rules' => 'number'
            ]
        ];

        $this->postJson(route('validate-payload'), $data)
            ->assertOk()
            ->assertExactJson([
                'status' => true,
            ])->assertJsonStructure([
                'status'
            ]);
    }

    /**
     * Test that validatePayload returns correct response for invalid data
     *
     * @return void
     */
    public function test_invalid_data_returns_validation_errors()
    {
        $data = [
            'first_name' => [
                'value' => 'John1',
                'rules' => 'alpha|required'
            ],
            'last_name' => [
                'value' => 'Doe',
                'rules' => 'alpha|required'
            ],
            'email' => [
                'value' => 'exampleexample.com',
                'rules' => 'email'
            ],
            'phone' => [
                'value' => '08175020329a',
                'rules' => 'number'
            ]
        ];

        $this->postJson(route('validate-payload'), $data)
            ->assertUnprocessable()
            ->assertExactJson([
                'status' => false,
                'errors' => [
                    'first_name' => [
                        'The first name field can only contain letters.'
                    ],
                    'email' => [
                        'The email field must be a valid email address.'
                    ],
                    'phone' => [
                        'The phone field must be a valid number.'
                    ]
                ]
            ])->assertJsonStructure([
                'status',
                'errors'
            ])->assertJsonValidationErrors([
                'first_name',
                'email',
                'phone'
            ]);
    }
}
