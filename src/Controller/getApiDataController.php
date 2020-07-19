<?php

namespace Drupal\node_json\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Database;

class getApiDataController extends ControllerBase {
    

public function getApiDataController($apikey, $node_id) {
 //header table
 $header_table = array(
 'node_id'=> t('id'),
 'apiKey' => t('apikey'),
 
 );

// fetching api key from config data
$config = \Drupal::service('config.factory')->getEditable('node_json.settings');
$api=$config->get('apiKey');

// verifying config apikey from entered api key in url
if($api==$apikey){

	$node_storage = \Drupal::entityTypeManager()->getStorage('node');
	$node = $node_storage->load($node_id);
	$type=$node->bundle();
	
	// verifying that node exist 
	if(!is_null($node)){



			 $rows=array();

			    $rows[] = array(
			    'apikey' => $apikey,
			    'title'=>$node->get('title')->value,
			    'type'=>$type,
			 );

			 //display data in site
			 $form['table'] = [
			 '#type' => 'table',
			 '#header' => $header_table,
			 '#rows' => $rows,
			 '#empty' => t('No users found'),
			 ];
			 return new JsonResponse( $form );


			}
			else{
				die("Error: Node does not exist.");
			}

	}



	else{
		die("Error: API key does not exist.");
	}

}}
