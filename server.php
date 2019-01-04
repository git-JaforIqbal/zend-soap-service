<?php

/**
 * Created by PhpStorm.
 * User: Jafor
 * Date: 16/24/2017
 * Time: 12:20 PM
 */
require_once 'vendor/autoload.php';
include 'SoapDefinition.php';

$serverUrl = "http://siteUrl.com/projectFolderName/server.php";
$options = [
    'uri' => $serverUrl,
];


$server = new Zend\Soap\Server(null, $options);
$server->setDebugMode(TRUE);
if (isset($_GET['wsdl'])) {
    $soapAutoDiscover = new \Zend\Soap\AutoDiscover(new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeSequence());
    $soapAutoDiscover->setBindingStyle(array('style' => 'document'));
    $soapAutoDiscover->setOperationBodyStyle(array('use' => 'literal'));
    $soapAutoDiscover->setClass('SoapDefinition');
    $soapAutoDiscover->setUri($serverUrl);

    header("Content-Type: text/xml");
    echo $soapAutoDiscover->generate()->toXml();
} else {
    $soap = new \Zend\Soap\Server($serverUrl . '?wsdl');
    $soap->setObject(new \Zend\Soap\Server\DocumentLiteralWrapper(new SoapDefinition()));
    $server->setPersistence(SOAP_PERSISTENCE_SESSION);
    $soap->handle();
}