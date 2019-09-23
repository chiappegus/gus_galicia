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



// Needed to generate absolute URL
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

// Needed to create the SOAP server
use Zend\Soap;

class SoapController extends Controller
{  
    public $theUri;
    /**
     * To display the WSDL you have to call http://.../soap/hello?wsdl (see @Route)
     *
     * @Route("/soap/hello", name="soap_hello")
     */
    public function hello()
    {
        // This wil generate the absolute URL of the current action (end point) based on it's route name
        $theUri = $this->generateUrl('soap_hello', [], UrlGeneratorInterface::ABSOLUTE_URL);

        // This is the object to instanciate when the webservice is invoked, use any controller
        $theService = new HelloController();
        //$theUri =$this->theUri;

        // Check if we should disply WSDL or execute the call
        if (isset($_GET['wsdl']))
           
            return $this->handleWSDL($theUri, $theService);
        else
            
            return $this->handleSOAP($theUri, $theService);

         
    }
    

   


    /**
     * To display the WSDL you have to call http://.../soap/hello?wsdl (see @Route)
     *
     * @Route("/soap/api_req", name="api_req")
     */
    public function api()
    {


      $status ='Hello , server time is ' . date ('H:i:s');
      dump($status);
      /*=====================================
      =            estoy con api            =
      =====================================*/
     // composer require symfony/http-client

      //https://symfony.es/noticias/2019/06/21/nuevo-en-symfony-43-componente-httpclient/
      
      /*=====  End of estoy con api  ======*/
      

      $httpClient = HttpClient::create();
$response = $httpClient->request('GET', 'https://api.github.com/repos/symfony/symfony-docs');

$statusCode = $response->getStatusCode();

dump($statusCode);

$content = $response->getContent();

dump($content);


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

//dump($content);

//NEW 
//
//$response = $httpClient->request
//
//"auth_basic", "auth_bearer", "query", "headers", "body", "json", "user_data", "max_redirects", "http_version", "base_uri", "buffer", "on_progress", "resolve", "proxy", "no_proxy", "timeout", "max_duration", "bindto", "verify_peer", "verify_host", "cafile", "capath", "local_cert", "local_pk", "passphrase", "ciphers", "peer_fingerprint", 
$clients = HttpClient::create(/*['user_data' => 'e2299ad9e3c66d757e21f157b318e90e']*/
/*['headers' => 'e2299ad9e3c66d757e21f157b318e90e']*/

  );

/*$response = $client->request('GET', 'https://httpbin.org/get', [
    // these values are automatically encoded before including them in the URL
    'query' => [
        'apikey' => 'e2299ad9e3c66d757e21f157b318e90e'
    ],
]);*/

/*$responseS = $clients->request( 'GET', 'https://api-2445582796097.staging.gw.apicast.io/api/v1/accounts',[
    // use a different HTTP Basic authentication only for this request
    'user_key' => 'e2299ad9e3c66d757e21f157b318e90e']);


You can pass headers with curl via the -H argument like so:

curl https://api-2445582796097.staging.gw.apicast.io/api/v1 -H "AUTH_USER: <e2299ad9e3c66d757e21f157b318e90e>"


*/
$responseS = $clients->request('GET', 'https://api-2445582796097.staging.gw.apicast.io/api/v1/accounts' , 
    [
    // these values are automatically encoded before including them in the URL
    'query' => [
        'apikey' => 'e2299ad9e3c66d757e21f157b318e90e'
   ],
]);

//var_dump($clients);

//dump($responseS);


$statusCodeS = $responseS->getStatusCode();

//dump($statusCodeS);
var_dump($statusCodeS);





$content1 = $responseS->getContent();

dump($content1);


$content = $responseS->toArray();
dump($content);

      return $this->render('default/index.html.twig', [
        'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);



    }

    /**
     * return the WSDL
     */
    public function handleWSDL($uri, $class)
    {
        // Soap auto discover
        $autodiscover = new Soap\AutoDiscover();
        $autodiscover->setClass($class);
        $autodiscover->setUri($uri);

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8'); // WSDL is a XML content
        
        // Start Output Buffering, nothing will be displayed ...
        ob_start();
        // Handle Soap
        $autodiscover->handle();
        // ... Stop Output Buffering and get content into variable
        $response->setContent(ob_get_clean());
        return $response;
    }

    /**
     * execute SOAP request
     */
    public function handleSOAP($uri, $class)
    {
        // Soap server
        $soap = new Soap\Server(null,
            array('location' => $uri,
                'uri' => $uri,
            ));
        $soap->setClass($class);

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        // Handle Soap
        $soap->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }
}
