<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Mahasiswa extends REST_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Mahasiswa_model', 'aliasMhs');

    $this->methods['index_get']['limit'] = 10;
    // $this->methods['index_delete']['limit'] = 2;
  }

  public function index_get()
  {
    $id = $this->get('id');
    if($id === null){
      $mahasiswa = $this->aliasMhs->getMahasiswa();
    } else{
      $mahasiswa = $this->aliasMhs->getMahasiswa($id);
    }
    //var_dump($mahasiswa); // hasilnya array

    if($mahasiswa){
      $this->response([
        'status' => TRUE,
        'data' => $mahasiswa
        // 'message' => 'No users were found'
    ], REST_Controller::HTTP_OK);
    }else{
      $this->response([
        'status' => FALSE,
        'message' => 'No users were found'
    ], REST_Controller::HTTP_NOT_FOUND);
    }
  }


  // Untuk menghapus versi wpu
  
  public function index_delete()
  {
    $id = $this->delete('id');

    if($id === null){
      $this->response([
        'status' => FALSE,
        'message' => 'Provide an ID'
    ], REST_Controller::HTTP_BAD_REQUEST);
    }else{
      if($this->aliasMhs->deleteMahasiswaById($id) > 0){
        // Oke
        $this->response([
          'status' => TRUE,
          'id' => $id,
          'message' => 'Deleted'
      ], REST_Controller::HTTP_OK);
      }else{
        // id not found
        $this->response([
          'status' => FALSE,
          'message' => 'ID not Found'
      ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }
  }
  


  // Versi gue
  /*
  public function index_delete()
    {
        // $id = (int) $this->get('id');
        $id = $this->delete('id');
        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $this->aliasMhs->deleteMahasiswaById($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }
    */


    public function index_post()
    {
      $data = [
        "nrp" => $this->post('nrp'),
        "nama" => $this->post('nama'),
        "email" => $this->post('email'),
        "jurusan" => $this->post('jurusan')
      ];

      if($this->aliasMhs->createMahasiswa($data) > 0){
        $this->response([
          'status' => TRUE,
          'message' => 'New Mahasiswa has been created'
      ], REST_Controller::HTTP_CREATED);
      }else{
        $this->response([
          'status' => FALSE,
          'message' => 'Fail to create new data mahasiswa'
      ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }

    public function index_put()
    {
      $id = $this->put('id');
      $data = [
        "nrp" => $this->put('nrp'),
        "nama" => $this->put('nama'),
        "email" => $this->put('email'),
        "jurusan" => $this->put('jurusan')
      ];

      if($this->aliasMhs->updateMahasiswa($data, $id) > 0){
        $this->response([
          'status' => TRUE,
          'message' => 'New Mahasiswa has been updated'
      ], REST_Controller::HTTP_OK);
      }else{
        $this->response([
          'status' => FALSE,
          'message' => 'Fail to update new data mahasiswa'
      ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }
}
?>