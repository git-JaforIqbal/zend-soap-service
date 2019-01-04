<?php


/**
 * Created by PhpStorm.
 * User: Jafor
 * Date: 16/24/2017
 * Time: 12:20 PM
 */

class ResponseHelper {

    public function responseCode($errorCode) {

        $codeArray = array(
            111 => 'Technical Error 5001',
            101 => 'Given token has been expired.',
            200 => 'Success',
            201 => 'Successfully Completed.',
            202 => 'Failed to save token.',
            203 => 'Wrong user credentials .',
            204 => 'No data found.',
            205 => 'Data Found',
            208 => 'Invalid token',
            209 => 'Duplicate Number',
            210 => 'Agent code is empty',
            211 => 'This xxx number doesn\'t exist.',
            212 => 'Cannot do such operation with this xxx',
            214 => 'Cannot do such xxx with the selected xx',
            215 => 'Payout country code should be number.',
            216 => 'Partner’s system reference number cannot be empty.',
            217 => 'Please enter valid date. Date Format: DD-MM-YYYY',
            218 => 'Entry date cannot be empty. Date Format: DD-MM-YYYY',
            219 => 'Transfer amount cannot be empty.',
            220 => 'Transfer currency cannot be empty.',
            221 => 'Payout currency cannot be empty.',
            222 => 'Payout amount cannot be empty.',
            223 => 'Rate cannot be empty.',
            229 => 'Payment mode cannot be empty.',
            230 => 'Invalid payment mode.',
            231 => 'Signature cannot be empty.',
            232 => 'Invalid signature.',
            233 => 'Invalid payout currency',
            234 => 'Invalid payout country code',
            235 => 'Technical Error:5001',
            401 => 'User is not active.',
            407 => 'Required parameter empty.',
        );

        if ($errorCode != '' && array_key_exists($errorCode, $codeArray)) {
            return $codeArray[$errorCode];
        } else {
            return $codeArray[10];
        }
    }

    public function specialResponse($responseCode = null, $data = null, $statusCode = null) {

        $response = new stdClass();
        $response->RESPONSE_CODE = $responseCode;
        $response->$statusCode = $data;
        return $response;
    }

    public function successResponse($responseCode = null, $data = null) {
        $response = new stdClass();
        $response->RESPONSE_CODE = $responseCode;
        $response->MESSAGE = $this->responseCode($responseCode);
        $response->RESPONSE_DATA = $data;
        return $response;
    }

    public function errorResponse($responseCode = null, $data = null) {
        $response = new stdClass();
        $response->RESPONSE_CODE = $responseCode;
        $response->MESSAGE = $this->responseCode($responseCode);
        $response->RESPONSE_DATA = $data;
        return $response;
    }


}
