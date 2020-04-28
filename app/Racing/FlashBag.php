<?php

namespace Racing;

class FlashBag
{

    public function __construct()
    {
        $bStatut = false;
        if (php_sapi_name() !== 'cli' ) {
            $bStatut = (session_status() === PHP_SESSION_ACTIVE ? true : false);
        }    
        if ($bStatut === false) session_start();

    }

     /**
     * Enregistrement d'un message
     * @param string message à afficher
     * @param string type success | warning
     */
    public function set($message, $type = 'success')
    {
        $_SESSION['flashbag'] = [
            'message' => $message,
            'type'  => $type
        ];
    }

    /**
    * Retourne le message et le type de message se trouvant dans
    * la session flash (tableau vide si pas de message)
    *
    * @return array
    */
    public function get()
    {
        if (!empty($_SESSION['flashbag']) && is_array($_SESSION['flashbag'])) {
            $return = $_SESSION['flashbag'];
            // Le principe des sessions flash étant qu'elles sont utilisées 
            // qu'une seule fois donc on supprime pendant le Get
            unset($_SESSION['flashbag']);
            return $return;
        }
        
    }


}

/****Mongo db****/

use \MongoDB\Client;
    	$client = new Client('mongodb://localhost:27017/?readPreference=primary&appname=MongoDB%20Compass%20Community&ssl=false');


$db = $client->admin->restaurants;

// Select * FROM restaurants
$results = $db->find([]);

// Select * FROM restaurants WHERE borough = 'Bronx'

// { 'borough' : 'Bronx' }

$results = $db->find([ 'borough' => 'Bronx' , 'cuisine' => 'Bakery']);

// SELECT name FROM restaurants

$options = [ 
    'projection' => [ "name" => 1 , "borough" => 1 , "cuisine" => 1],
    'sort' => [ 'name' => -1]

];

$results = $db->find([] , $options );

// SELECT name FROM restaurants WHERE borough = 'Bronx' OR borough = 'Brooklyn'

$filter = [ '$or' => 
           [
               [ 'borough' => 'Bronx' ],
               [ 'borough' => 'Brooklyn' ]
           ]
          ];


$results = $db->find( $filter , $options );

foreach ($results as $restaurant) {
    //echo $entry['_id'], ': ', $entry['borough'], "\n";
    //var_dump($entry);
    echo $restaurant['name'] . $restaurant['cuisine'] . "<br>";
}

// Aggregation

// SELECT COUNT(id) FROM restaurants WHERE borough ='Brooklyn' 
// SELECT COUNT(id) FROM restaurants WHERE borough ='Brooklyn'  GROUPE BY name

$pipeline = [ 
    [
        '$match' => [ 'borough' => 'Brooklyn']
    ],
    [
        '$group' => [ 
            '_id' => null, // groupement general
            "count" => [ '$sum' =>  1 ]
        ]
    ]

];


$results = $db->aggregate( $pipeline )->toArray();

echo 'count : ' . $results[0]['count'];

// INSERT INTO restaurants( colonnes ..) VALUES ( 'KFC', ... )

//$db->insertOne( [ "nom" => "siriphol" , "prenom" => "dany"]);

// DELETE FROM restaurants WHERE nom = 'Siriphol'

$db->deleteOne( [ "nom" => "siriphol" ]);
//$db->deleteMany( [ "borough" => "Brooklyn" ]);

// UPDATE FROM restaurants SET nom = "S" WHERE nom = "Siriphol"

$db->updateOne(
    [ 'restaurant_id' =>  '30075445' ],
    [ '$set' => [ 'cuisine' => 'Pizza' ]]

);