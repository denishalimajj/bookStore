<?php

namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HandlesValidationErrors
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $firstError = $this->formatFirstError($errors);

        $response = response()->json($firstError, 422);

        throw new HttpResponseException($response);
    }

    private function formatFirstError(array $errors)
    {
        foreach ($errors as $messages) {
            foreach ($messages as $message) {
                return $this->getErrorDetails($message);
            }
        }

        return [
            'code' => 42200,
            'message' => 'Validation error occurred',
            'description' => 'An unknown validation error occurred.',
        ];
    }

    private function getErrorDetails($message)
    {
        $errorMappings = __('exceptions');

        return $errorMappings[$message] ?? [
            'code' => 42200,
            'message' => $message,
            'description' => 'Validation error occurred.',
        ];
    }
}
