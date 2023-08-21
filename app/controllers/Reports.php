<?php
  #[AllowDynamicProperties]
  class Reports extends Controller {
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }

      // reportModel is a Dynamic Property in PHP
      $this->reportModel = $this->model('Report');
      $this->userModel = $this->model('User');
    }

    public function index() {

      $clientCompany = $_SESSION['user_company'];
      $OMClientCampaigns = $this->reportModel->getDealsByClient($clientCompany);

      $data = [
        'clientCampaigns' => $OMClientCampaigns,
        'companyName' => $OMClientCampaigns[0]->clientName,
        'company' => $clientCompany,
        'name' => $_SESSION['user_name']
      ];

      $_SESSION['clientCampaigns'] = $OMClientCampaigns;
      $_SESSION['companyName'] = $OMClientCampaigns[0]->clientName;

      $this->view('reports/index', $data);
    }

    public function run(){

        $campaignId = $_COOKIE['campaignID'];
        $Emails = $this->reportModel->getTotalEmailsSent($campaignId);
        $interval = ceil($Emails->totalEmails/1000);

        $_SESSION['interval'] = $interval;
        
        // Get reports

        $OMactivityUrls3a = 'https://apiconnector.com/v2/campaigns/' . $campaignId . '/activities?select=1000&skip=0';
        $OMactivityUrls3b = 'https://apiconnector.com/v2/campaigns/' . $campaignId . '/activities?select=1000&skip=1000';
        $OMactivityUrls3c = 'https://apiconnector.com/v2/campaigns/' . $campaignId . '/activities?select=1000&skip=2000';

        $OMactivityUrls2a = 'https://apiconnector.com/v2/campaigns/' . $campaignId . '/activities?select=1000&skip=0';
        $OMactivityUrls2b = 'https://apiconnector.com/v2/campaigns/' . $campaignId . '/activities?select=1000&skip=1000';   
        
        $OMactivityUrls1 = 'https://apiconnector.com/v2/campaigns/' . $campaignId . '/activities?select=1000&skip=0';

        switch ($interval) {
            case 3:
                $OMData1 = $this->reportModel->getOMData($OMactivityUrls3a);
                $OMData2 = $this->reportModel->getOMData($OMactivityUrls3b);
                $OMData3 = $this->reportModel->getOMData($OMactivityUrls3c);
                $OMData = array_merge($OMData1,$OMData2,$OMData3);
                $OMContacts = $this->reportModel->getContacts();
                $clientCampaigns = $this->reportModel->getCampaigns();
                $OMCampaignSummary = $this->reportModel->getCampaignSummary($campaignId);
                $data = [
                  'campaignContactData' => $OMContacts,
                  'CampaignSummary' => $OMCampaignSummary,
                  'OMCampaignActivity' => $OMData,
                  'campaigns' => $clientCampaigns
                ];
                $this->createDataSession($OMData, $OMContacts, $OMCampaignSummary, $clientCampaigns);
                $this->view('reports/run', $data);
                break;
            case 2:
                $OMData1 = $this->reportModel->getOMData($OMactivityUrls2a);
                $OMData2 = $this->reportModel->getOMData($OMactivityUrls2b);
                $OMData = array_merge($OMData1,$OMData2);
                $OMContacts = $this->reportModel->getContacts();
                $clientCampaigns = $this->reportModel->getCampaigns();
                $OMCampaignSummary = $this->reportModel->getCampaignSummary($campaignId);
                $data = [
                  'campaignContactData' => $OMContacts,
                  'CampaignSummary' => $OMCampaignSummary,
                  'OMCampaignActivity' => $OMData,
                  'campaigns' => $clientCampaigns
                ];
                $this->createDataSession($OMData, $OMContacts, $OMCampaignSummary, $clientCampaigns);
                $this->view('reports/run', $data);
                break;
            case 1: 
                $OMData = $this->reportModel->getOMData($OMactivityUrls1);
                $OMContacts = $this->reportModel->getContacts();
                $clientCampaigns = $this->reportModel->getCampaigns();
                $OMCampaignSummary = $this->reportModel->getCampaignSummary($campaignId);
                $data = [
                  'campaignContactData' => $OMContacts,
                  'CampaignSummary' => $OMCampaignSummary,
                  'OMCampaignActivity' => $OMData,
                  'campaigns' => $clientCampaigns
                ];
                $this->createDataSession($OMData, $OMContacts, $OMCampaignSummary, $clientCampaigns);
                $this->view('reports/run', $data);
                break;
              }
      }


      public function createDataSession($OMData, $OMContacts, $OMCampaignSummary, $clientCampaigns) {
          $_SESSION['OMData'] = $OMData;
          $_SESSION['campaignContactData'] = $OMContacts;
          $_SESSION['OMCampaignSummary'] = $OMCampaignSummary;
          $_SESSION['campaigns'] = $clientCampaigns;
      }

      public function logout() {
          unset($_SESSION['OMData']);
          unset($_SESSION['campaignContactData']);
          unset($_SESSION['OMCampaignSummary']);
          unset($_SESSION['OMDeals']); 
          unset($_SESSION['OMClients']);
          unset($_SESSION['OMCampaigns']);
          unset($_SESSION['campaigns']);
          session_destroy();
          redirect('users/login');
      }
  }