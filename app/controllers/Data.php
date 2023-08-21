<?php
  #[AllowDynamicProperties]
  class Data extends Controller {
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }

      $this->datumModel = $this->model('Datum');
      $this->userModel = $this->model('User');


    }

    public function index() {
        // Get Campaign Data

        $OMCampaignDataCount = $this->datumModel->getCountCampaigns();
        //print_r($OMCampaignDataCount);
        $data = [
            'OMCampaignCount' => $OMCampaignDataCount
          ];

        //print_r(json_encode($contacts));

        $this->view('data/index', $data);
      }

    public function update() {
        $OMCampaignDataUpdate = $this->datumModel->updateCampaignsTable();
        $OMCampaignDataCount = $this->datumModel->getCountCampaigns();

        //$result = $this->datumModel->addCampaigns($OMCampaignDataUpdate);

        //print_r($OMCampaignDataUpdate);

        $data = [
            'update' => $OMCampaignDataUpdate,
            'OMCampaignCount' => $OMCampaignDataCount
          ];

          //print_r($data);

        
          $this->view('data/update', $data);
    }
  }