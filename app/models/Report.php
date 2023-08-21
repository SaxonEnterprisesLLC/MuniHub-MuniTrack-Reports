<?php
       
    class Report {

        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getContacts() {
            $this->db->query('SELECT
                            ContactID as contactId,
                            sector as sector,
                            role as role,
                            company as company
                            FROM OMContact');

            $results = $this->db->resultSet();
            return $results;
        }

        public function getCampaignSummary($campaignId) {
            $this->db->query('SELECT
                            fkCampaignID as campaignId,
                            numTotalUniqueOpens as totalUniqueOpens,
                            numTotalOpens as totalOpens,
                            numTotalClicks as totalClicks,
                            numTotalSent as totalSent
                            FROM OMCampaignSummary
                            WHERE fkCampaignID =' . $campaignId);

            $results = $this->db->single();
            return $results;
        }

        public function getClientList() {
            $this->db->query('SELECT ClientID as `clientId`, 
                                    ClientName as `clientName`
                            FROM clients
                            ORDER BY ClientName');

            $results = $this->db->resultSet();
            return $results;
        }

        public function getDealsByClient($id) {
            $this->db->query('SELECT d.DealClientID as `clientId`, 
                                    c.ClientName as `clientName`, 
                                    d.DealID as `dealId`, 
                                    o.CampaignId as `campaignId`, 
                                    o.CampaignName as `campaignName`,
                                    d.DealTitle as `dealTitle`,
                                    DATE_FORMAT(d.DealDate, "%M %d, %Y") as `dealDate`
                            FROM deals as d
                            INNER JOIN clients as c ON d.DealClientID = c.ClientID
                            INNER JOIN OMCampaigns as o ON d.DealID = o.dealId
                            WHERE d.DealClientID =' . $id . '
                            AND o.OMStatus = "Sent" 
                            ORDER BY d.DealDate DESC');

            $results = $this->db->resultSet();
            return $results;
        }

        public function getCampaigns() {
            $this->db->query('SELECT
                            SentDate as sentDate,
                            OMStatus as status,
                            CampaignId as campaignId,
                            CampaignName as campaignName,
                            CampaignSubject as campaignSubject,
                            CampaignDisplayName as campaignDisplayName,
                            DealId as dealId
                            FROM OMCampaigns');

            $results = $this->db->resultSet();
            return $results;
        }

        public function getCampaign($campaignId) {
            $this->db->query('SELECT
                            SentDate as sentDate,
                            CampaignId as campaignId,
                            CampaignName as campaignName,
                            CampaignSubject as campaignSubject,
                            CampaignDisplayName as campaignDisplayName,
                            DealId as dealId
                            FROM OMCampaigns
                            WHERE CampaignId = ' . $campaignId);

            $results = $this->db->single();
            return $results;
        }

        public function getTotalEmailsSent($campaignId) {
            $this->db->query('SELECT
                            numTotalDelivered as totalEmails
                            FROM OMCampaignSummary
                            WHERE fkCampaignID = ' . $campaignId);

            $results = $this->db->single();
            return $results;
        }

        // Getting all report data needed ASYNC PHP
        public function getOMData($OMactivityUrl) {

            /*  gets the OM contacts of the Campaign
             *  contactId
             *  numOpens
             *  numClicks
             */
                $curl = curl_init();
                //echo $OMactivityUrl . '<br>';
                curl_setopt_array($curl, array(
                CURLOPT_URL => $OMactivityUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    API_USER,
                    'Accept: ' . 'application/json' ,
                    'Content-Type: application/json'
                ),
                ));

                $response = json_decode(curl_exec($curl));

                curl_close($curl);
                return $response;
        }
    }
        
        
        
        
        