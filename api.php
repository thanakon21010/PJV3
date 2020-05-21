<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'api/vendor/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        // Database connection settings
        "db" => [
            "host" => "127.0.0.1",
            "dbname" => "hermes",
            "user" => "root",
            "pass" => "" //1q2w3e4r
        ],
    ],
];


$app = new \Slim\App ($config);

// DIC configuration
$container = $app->getContainer();

// PDO database library 
$container ['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
 

$app->get('/get', function (Request $request, Response $response, array $args) {
    
    $sql = "Select * from agency";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
    return $this->response->withJson($sth);
});

$app->get('/agency/get', function (Request $request, Response $response, array $args) {
    
    $sql = "Select * from agency";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
    return $this->response->withJson($sth);
});

$app->post('/agency/add', function (Request $request, Response $response, array $args) {
    if(!empty($_REQUEST['agency_code'])){
        $sql = "INSERT into agency values('" . $_REQUEST['agency_code']."','".$_REQUEST['agency_name']."', '".$_REQUEST['agency_price']."','".$_REQUEST['agency_contact_name']."','".$_REQUEST['agency_email']."','".$_REQUEST['agency_telno']."','".$_REQUEST['agency_address']."','".$_REQUEST['agency_comment']."' )";
        $this->db->query($sql);

        if(!$sql){
            $return['result'] = "ERR";

        }else{
            $return['result'] = "OK";
            $return['status'] = "Add to menu complete";
        }
            return $this->response->withJson($return);

        }

});

$app->post('/add', function (Request $request, Response $response, array $args) {
 
    $show = $_POST;
    $agency_code = $show['agency_code'];
    $agency_name = $show['agency_name'];
    $agency_price = $show['agency_price'];
    $agency_contact_name = $show['agency_contact_name'];
    $agency_email = $show['agency_email'];
    $agency_telno = $show['agency_telno'];
    $agency_address = $show['agency_address'];
    $agency_comment = $show['agency_comment'];
    
    $sql = "INSERT INTO agency VALUES ('$agency_code','$agency_name','$agency_price','$agency_contact_name','$agency_email','$agency_telno','$agency_address','$agency_comment') ";
    // $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
   
    $this->db->query($sql);
    return $this->response->withJson();
});

$app->post('/login', function (Request $request, Response $response, array $args) use($app){

    $json = $app->request->getBody();

    $data = json_decode($json, true);
    
    $uname = $data['username'];
    $password =$data['password'];
 
    $result =(object)array('message'=> 'Hello,'.$uname);
    
  /*  if ($uname != "" && $password != ""){

        $sql_query = "SELECT count(*) as cntUser FROM users WHERE username='".$uname."' and password='".$password."'";

        $result = mysqli_query($sql_query);
        $row = mysqli_fetch_array($result);
    
        $count = $row['cntUser'];
    
        if($count > 0){
            $_SESSION['uname'] = $uname;
            echo 1;
        }else{
            echo 0;
        }
    
    }*/
});


 

$app->run();
