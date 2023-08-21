<?php
    class Datum {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function updateCampaignsTable() {
            $OMHeader = API_USER;

            $OMCampaignDetails = 'https://apiconnector.com/v2/campaigns/with-details?';

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $OMCampaignDetails,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array($OMHeader),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $rows=json_decode($response);

            //print_r($x);
            
            foreach ($rows as $row) {
                //echo gettype($y->tags[0]->name);
                $dataObj = new stdClass();
                $dataObj->CampaignId = $row->id;
                $dataObj->CampaignName = $row->name;
                $dataObj->CampaignSubject = $row->subject;
                $dataObj->OMStatus = $row->status;
                $dataObj->SentDate = $row->sentDate;

                if (empty($row->tags)) {
                    //echo("array empty");
                    $dataObj->DealId = 11111;
                } elseif ($row->tags[0]->name != "") {
                    $dataObj->DealId = $row->tags[0]->name;
                } else {
                    $dataObj->DealId = 11111;
                    }
                
                $dataArray[] = $dataObj;
            }

            //print_r($dataArray);
            
            //print_r($result);
            $campaigns = $dataArray;
            $count = count($campaigns);
            //echo 'Total Records Inserting: ' . $count;
            foreach($campaigns as $campaign) {
                
                $this->db->query('INSERT INTO OMCampaigns (OMStatus, CampaignId, CampaignName, CampaignSubject, CampaignDisplayName, DealId, SentDate) 
                                VALUES (:OMStatus, :CampaignId, :CampaignName, :CampaignSubject, :CampaignDisplayName, :DealId, :SentDate) 
                                ON DUPLICATE KEY UPDATE OMStatus = :OMStatus, CampaignName = :CampaignName, CampaignSubject = :CampaignSubject, DealId = :DealId, SentDate = :SentDate');
                $this->db->bind(':OMStatus', $campaign->OMStatus);
                $this->db->bind(':CampaignId', $campaign->CampaignId);
                $this->db->bind(':CampaignName', $campaign->CampaignName);
                $this->db->bind(':CampaignSubject', $campaign->CampaignSubject);
                $this->db->bind(':DealId', $campaign->DealId);
                $this->db->bind(':SentDate', $campaign->SentDate);
                $this->db->bind(':CampaignDisplayName', '');

                //execute
                $this->db->execute();
            }

            //$this->db->execute();

            //$jsonData = json_encode($dataArray);
             
            return $dataArray;
    
        }

        public function getCountCampaigns() {
            $this->db->query('SELECT count(*) as TotalCampaigns
                            FROM OMCampaigns
                            ');

            $row = $this->db->single();
            return $row;

        }

        public function addCampaigns($campaigns) {
            $campaigns = array($campaigns);

            foreach($campaigns as $campaign) {
                $this->db->query('REPLACE INTO OMCampaigns (OMStatus, CampaignId, CampaignName, CampaignSubject, DealId ) 
                            VALUES (:OMStatus, :CampaignId, :CampaignName, :CampaignSubject, :DealId)');
                
                $this->db->bind(':OMStatus', $campaign['OMStatus']);
                $this->db->bind(':CampaignId', $campaign['CampaignId']);
                $this->db->bind(':CampaignName', $campaign['CampaignName']);
                $this->db->bind(':CampaignSubject', $campaign['CampaignSubject']);
                $this->db->bind(':DealId', $campaign['DealId']);
                
                // execute
                if ($this->db->execute()) {
                    return true;
                } else {
                    return false;
                }

            }
            

        }

        public function getCampaignById($id) {
            $this->db->query('SELECT * from OMCampaigns WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();
            
            return $row;
        }
    }
