<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class ValidationHelper {
    //Validación de campo Limit
    public static function validateLimit($request) {
        //Define reglas y mensajes de respuesta
        $rules = [
            'limit' => 'required|numeric',
            'offset' => 'required|numeric'
        ];

        $messages = [
            'limit.required' => __('messages.limit_field_required'),
            'limit.numeric' => __('messages.limit_field_numeric'),
            'offset.required' => __('messages.offset_field_required'),
            'offset.numeric' => __('messages.offset_field_numeric')
        ];

        //Validación de campos
        $result = self::validationProcess($request, $rules, $messages);
        return $result;
    }

    //Proceso de validación de campos y armado de respuesta
    private static function validationProcess($request, $rules, $messages) {
        $validator = Validator::make($request, $rules, $messages);

        if($validator->fails()) {
            $errors = [];
            foreach($validator->errors()->messages() as $message) {
                array_push($errors, $message);
            }
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        return [
            'success' => true
        ];
    }
}