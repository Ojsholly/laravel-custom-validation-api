<?php

namespace Tests\Unit;

use App\Traits\PayloadValidationTrait;
use PHPUnit\Framework\TestCase;

class PayloadValidationTraitTest extends TestCase
{
    use PayloadValidationTrait;

    /**
     * Test that valid data passes the validation
     *
     * @return void
     */
    public function test_valid_data_passes_validation(): void
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
        $validationErrors = $this->getValidationErrors($data);
        $this->assertEmpty($validationErrors);
    }

    /**
     * Test that invalid data fails the validation and returns the appropriate validation errors.
     *
     * @return void
     */
    public function test_invalid_data_returns_validation_errors(): void
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

        $validationErrors = $this->getValidationErrors($data);

        $this->assertArrayHasKey('first_name', $validationErrors);
        $this->assertArrayHasKey('email', $validationErrors);
        $this->assertArrayHasKey('phone', $validationErrors);
    }
}
