<?php

/**
 * Require the submission service.
 */
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/services/CleOpenStudioAppSubmissionService.php'); 

function _cle_open_studio_app_submission_findone($machine_name, $app_route, $params, $args) {
  $return = '';
  $status = 200;
  $method = $_SERVER['REQUEST_METHOD'];

  // Find out if there is a nid specified
  if ($method == 'GET' || $method == 'PUT') {
    if (isset($args[2])) {
      $nid = $args[2];
      if ($nid) {
        // if it's a GET method then we can return the node.
        switch ($method) {
          case 'GET':
            $service = new CleOpenStudioAppSubmissionService();
            $return = $service->getSubmission($args[2]);
            break;
          case 'PUT':
            $service = new CleOpenStudioAppSubmissionService();
            $post_data = file_get_contents("php://input");
            $post_data = json_decode($post_data);
            $return = $service->updateSubmission($post_data, $args[2]);
            break;
          default:
            # code...
            break;
        }
        // if ($method == 'GET') {
        //   $return = $node;
        // }
        // if ($method == 'PUT') {
        //   $post_data = file_get_contents("php://input");
        //   $post_data = json_decode($post_data);
        //   if (isset($post_data->title)) {
        //     $node->title = filter_xss($post_data->title);
        //     node_save($node);
        //     $status = 201;
        //   }
        //   $return = $post_data;
        // }
      }
      else {
        $status = 404;
      }
    }
  }

  return array(
    'status' => $status,
    'data' => $return
  );
}

function _cle_open_studio_app_submission_index($machine_name, $app_route, $params, $args) {
  $return = [];
  $status = 200;
  $service = new CleOpenStudioAppSubmissionService();

  $return = $service->getSubmissions();

  return array(
    'status' => 200,
    'data' => $return
  );
}

// function cle_open_studio_app_cle_open_studio_app_encode_submission_alter(&$submissions) {
//   if (_assignment_is_open()) {
//     $action = new stdClass();
//     $action->title = 'Make a Submission';
//     $action->url = '/lrnapp-submission/create';
//     $submissions->actions[] = $action;
//   }
// }