<?php


/**
 * Created by PhpStorm.
 * User: Jafor
 * Date: 16/24/2017
 * Time: 12:20 PM
 */
require_once 'ResponseHelper.php';
require_once 'OperationHelper.php';

// For secure token / password
use Zend\Crypt\Password\Bcrypt;

class SoapDefinition
{

    var $response;
    var $operation;

    public function __construct()
    {
        $this->response = new ResponseHelper();
        $this->operation = new OperationHelper();
    }


    /**
     * soapDefinition yourFunctionName
     *
     * @param string $ParameterName1
     * @param string $ParameterName2
     * @return string $returnType
     */
    public function yourFunctionName($parameterName1, $parameterName2)
    {

        if ($parameterName1 == '' || $parameterName2 == '') {
            $output = $this->response->response(407);
        } else {

            $bcrypt = new Bcrypt();
            $dataSet = $parameterName1 . $parameterName2;
            $token = $this->clean(strtoupper($bcrypt->create($dataSet)));
            $responseCodeSTI = $this->operation->simpleDbOperation($parameterName1, $parameterName2);


            if ($responseCodeSTI->RESPONSE_CODE == 200) {
                $output = $this->response->specialResponse($responseCodeSTI->RESPONSE_CODE, $responseCodeSTI->TOKEN, 'TOKEN_ID');
            } else {
                $output = $this->response->errorResponse($responseCodeSTI->RESPONSE_CODE);
            }

        }

        return json_encode($output);
    }


    private function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '$', $string); // Removes special chars.
    }




}
