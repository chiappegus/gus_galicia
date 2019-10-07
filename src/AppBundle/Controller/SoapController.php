<?php
/**
 * Simple SOAP Server - v1
 * 
 * Create a simple HelloWorld SOAP server. The main function (hello) is defined in HelloController 
 * which is a basic Controller. To publish a method of HelloController we've created this controller 
 * (SoapController) where we have one + two methods : 
 *  - First one  : how to publish all public methods of HelloController
 *  - Second one : how to generate the WSDL of the service
 *  - Third one  : how to call a method 
 * 
 * If you have a new controller to publish simply duplicate the first method and update these data : 
 *  - The route and it's name
 *  - The url
 *  - The instance of the new controller
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//nuevo para probar la api
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\CurlHttpClient;



// Needed to generate absolute URL
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

// Needed to create the SOAP server
use Zend\Soap;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class SoapController extends Controller
{  
  public $theUri;
    
    

    


    /**
     * To display the WSDL you have to call http://.../soap/hello?wsdl (see @Route)
     *
     * @Route("/soap/api_req", name="api_req")
     */
    public function api()
    {


     // $status ='Hello , server time is ' . date ('H:i:s');
     // dump($status);
      /*=====================================
      =            estoy con api            =
      =====================================*/
     // composer require symfony/http-client

      //https://symfony.es/noticias/2019/06/21/nuevo-en-symfony-43-componente-httpclient/
      
      /*=====  End of estoy con api  ======*/
      

      $httpClient = HttpClient::create();
      $response = $httpClient->request('GET', 'https://api.github.com/repos/symfony/symfony-docs');

      $statusCode = $response->getStatusCode();

      //dump($statusCode);

      $content = $response->getContent();

      //dump($content);


//https://galicia-innovation.3scale.net/docs
      //
      //
      //
       $response = $httpClient->request('GET', 'https://api-2445582796097.staging.gw.apicast.io/api/v1/accounts?apikey=e2299ad9e3c66d757e21f157b318e90e');
      
      $statusCode = $response->getStatusCode();

//dump($statusCode);

      $content = $response->getContent();

//dump($content);


      $content = $response->toArray();


      $clients = HttpClient::create();



$lugar='accounts';
$responseS = $clients->request('GET', 'https://api-2445582796097.staging.gw.apicast.io/api/v1/'.$lugar , 
  [
    // these values are automatically encoded before including them in the URL
  'query' => [
  
  'apikey' => 'e2299ad9e3c66d757e21f157b318e90e'
  ],
  ]);




$statusCodeS = $responseS->getStatusCode();

echo "GET";
var_dump($statusCodeS);


$content = $responseS->getContent();

$content = $response->toArray();
//var_dump($content);




$content1 = $responseS->getContent();

//dump($content1);


$content = $responseS->toArray();
//dump("pepe");

$lugar='loans/mortgage_simulation';

$response1 = $clients->request('GET', 'https://api-2445582796097.staging.gw.apicast.io/api/v1/'.$lugar , 
  [
    // these values are automatically encoded before including them in the URL
  'query' => [
  
  'apikey' => 'e2299ad9e3c66d757e21f157b318e90e'
  ],
  ]);



$statusCodeS = $response1->getStatusCode();

echo "loans  ";
var_dump($statusCodeS);
$content2 = $response1->getContent(false);
/*$data = file_get_contents($content2);*/
$products = json_decode($content2, true);
$arr = json_decode($content2, true);


 


/*echo "<br/>aca<br/>";
 var_dump(array_filter($arr, function($k) {
    return $k == 'status';
}, ARRAY_FILTER_USE_KEY));

echo "<br/>aca2<br/>";
 var_dump(array_filter($arr, function($k) {
    return $k == 'status';
}, ARRAY_FILTER_USE_BOTH ));

//var_dump($products);

echo "<br/>aca3<br/>";
echo "<br/>aca3<br/>";
foreach ($products as $product) {
    echo '<pre>';
    print_r($product);
    echo '</pre>';
}

if ($products['status']==405) {
 echo "chupa me un huevo";
}*/






//$content2 =$response1->toArray(false);

//var_dump($content2['message']);

/*
https://stackoverflow.com/questions/16920291/post-request-with-json-body
POST VER
/creditcards

[
  {
    "Id": 102,
    "Customer_Id": 1542,
    "Buy_Limit": "500000.0",
    "Category": "consumidor"
  }
]




*/


$clientss = HttpClient::create(['auth_bearer' => 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2MDE5OTQ2ODgsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJndXN0YXZvY2hpYXBwZUB5YWhvby5jb20uYXIifQ.7e9pwwZNNcNVl3D_MG8Yv3t8_BazR-_wU_4R-mOMzNLF8U07FdtOmXrsZ9KxMi19nOgMP3th98TBd7lkuadRbQ']
  );

$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/usd_of_minorista');



$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));

$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/base');

$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));



$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/base_usd');

$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));



      //
      //
$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/lebac_usd');

$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));



$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/leliq_usd');






$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));






      //
      //
$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/tasa_leliq');


$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));


$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/uva');


$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));



$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/merval_usd');


$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));

$responseBCRA = $clientss->request('GET', 'https://api.estadisticasbcra.com/var_usd_of_anual');


$statusCodeSs = $responseBCRA->getStatusCode();
dump($statusCodeSs);


dump( $responseBCRA->getContent(false));



return $this->render('default/index.html.twig', [
  'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
  ]);



}
}
