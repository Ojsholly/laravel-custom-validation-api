<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait PayloadValidationTrait
{
    /**
     * @param array $data
     *
     * @return array
     */
    private function getValidationErrors(array $data): array
    {
        $validationErrors = [];

        foreach ($data as $field => $value) {
            $rules = explode('|', $value['rules']);

            foreach ($rules as $rule) {
                $validationFunction = 'validate' . Str::studly($rule);

                if (method_exists($this, $validationFunction)) {
                    $validationError = $this->$validationFunction($value['value'], Str::replace('_', ' ', $field));
                    if ($validationError) {
                        $validationErrors[$field][] = $validationError;
                    }
                }

            }

        }
        return $validationErrors;
    }

    /**
     * @param $value
     * @param $field
     *
     * @return string|null
     */
    private function validateAlpha($value, $field): ?string
    {
        if (!ctype_alpha($value)) {
            return 'The ' . $field . ' field can only contain letters.';
        }
        return null;
    }

    /**
     * @param $value
     * @param $field
     *
     * @return string|null
     */
    private function validateRequired($value, $field): ?string
    {
        if (empty($value)) {
            return 'The ' . $field . ' field is required.';
        }
        return null;
    }

    /**
     * @param $value
     * @param $field
     *
     * @return string|null
     */
    private function validateEmail($value, $field): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'The ' . $field . ' field must be a valid email address.';
        }
        return null;
    }

    /**
     * @param $value
     * @param $field
     *
     * @return string|null
     */
    private function validateNumber($value, $field): ?string
    {
        if (!is_numeric($value)) {
            return 'The ' . $field . ' field must be a valid number.';
        }
        return null;
    }
}
