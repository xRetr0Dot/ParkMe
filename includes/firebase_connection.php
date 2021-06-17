<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/includes/park-io-613f4-firebase-adminsdk-pxg7h-147d7e447e.json');

$firebase = (new Factory) -> withServiceAccount($serviceAccount)
                                                ->withDatabaseUri('https://park-io-613f4-default-rtdb.asia-southeast1.firebasedatabase.app');
                                                ->create();

$database = $firebase -> getDatebase();
$auth = $factory->createAuth();


?>