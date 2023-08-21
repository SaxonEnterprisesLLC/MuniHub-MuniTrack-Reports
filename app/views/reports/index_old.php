<?php require APPROOT . '/views/inc/header.php'; ?>
    <?php flash('post_message'); ?>
    <div class="row">
        <div class="col-md-6">
            <h1>Reports</h1>
        </div>
        <br/>
        <hr>
        <div class="dropdown">
            <h2>MuniHub Deal Campaign Reports</h2>
                <select id="clients" class="form-select form-select-lg mb-3" aria-label="MuniHub Deal Clients">
                    <option value="">-- Select a MuniHub Client --</option>
                </select>
                <div class="card">
                    <div class="card-body">
                        <p id="deal" class="card-title">This is what Client you selected: <br>
                            <span id="clientOutput"></span>
                        </p>
                        <button onclick="getCampaignClient()"> Check Client Chosen </button>
                    </div>
                </div>
                <br>
                <select id="campaigns" class="form-select form-select-lg mb-3" aria-label="MuniHub Deal Campaign Reports">
                    <option value="">-- Select Deal Campaign --</option>
                </select>
                <br>
                <div class="card">
                    <div class="card-body">
                        <p id="deal" class="card-title">This is what Munihub Campaign Deal ID you selected: <br>
                            <span id="campaignOutput"></span>
                        </p>
                        <button onclick="getCampaignOption()"> Check Deal Chosen </button>
                    </div>
                </div>
        </div>
    </div>
    
   <h4 class="card-title"><?php 
        
        $a = $data['Contacts'];
        //print('Total Contacts: ' . count($a)) . '<br>';
        for ($i=0; $i < count($a); $i++) {
            //print('Contact ID: ' . $a[$i]->contactId . '<br>');
        }

        $b = $data['Campaigns'];
        //print('Total Campaigns: ' . count($b)) . '<br>';
        for ($i=0; $i < count($b); $i++) {
            //print('Deal ID: ' . $b[$i]->dealId . '<br>');
        }

        if (isset($_SESSION['OMCampaignSummary'])) {
            //$response = $_SESSION['OMData'];
            $response = "Session OMCampaignSummary is available <br>";
        } else {
            $response = "Session variable OMCampaignSummary is not set";
        }
        //echo $response;

        ?>
        
        <!-- Grab data from $S_SESSION in PHP -->
        <script type="text/javascript">
            //let OMCampaignData = <?php echo json_encode($_SESSION['OMData']); ?>;
            let OMContacts = <?php echo json_encode($_SESSION['OMContacts']); ?>;
            let OMDeals = <?php echo json_encode($_SESSION['OMDeals']); ?>;
            let OMClients = <?php echo json_encode($_SESSION['OMClients']); ?>;
            let OMCampaigns = <?php echo json_encode($_SESSION['OMCampaigns']); ?>;
            //let OMCampaignSummary = <?php echo json_encode($_SESSION['OMCampaignSummary']); ?>;
            console.log('Campaign Activity', OMCampaignData, 'Contacts', OMContacts, 'Campaigns', OMCampaigns, 'Deals', OMDeals, 'Clients', OMClients);

            for (campaign in OMCampaigns) {
                    let selection = document.createElement('option');
                    selection.innerHTML = OMCampaigns[campaign].campaignName;
                    selection.value = OMCampaigns[campaign].campaignId + " ====> " + OMCampaigns[campaign].campaignName;

                    document.getElementById('campaigns').appendChild(selection);
            }

            for (client in OMClients) {
                    let selection = document.createElement('option');
                    selection.innerHTML = OMClients[client].clientName;
                    selection.value = OMClients[client].clientId + " ====> " + OMClients[client].clientName;

                    document.getElementById('clients').appendChild(selection);
            }

            const getCampaignOption = () => {
                selectElement = document.querySelector('#campaigns');
                selectedCampaign = selectElement.value;
                document.querySelector('#campaignOutput').textContent = selectedCampaign;
            }

            const getCampaignClient = () => {
                selectElement = document.querySelector('#clients');
                selectedClient = selectElement.value;
                document.querySelector('#clientOutput').textContent = selectedClient;
            }

            
        
        </script>

        <?php
        
        $c = $data['CampaignSummary'];
        //print('Total Campaign Summary: ' . count($c)) . '<br>';
        for ($i=0; $i < count($c); $i++) {
            //print('Campaign ID: ' . $c[$i]->campaignId . '<br>');
        }

        //$d = array_merge($data['OMCampaignActivity1'],$data['OMCampaignActivity2'],$data['OMCampaignActivity3']);
        $d = $data['OMCampaignActivity'];
        //print('OM Campaign Contacts: ' . count((array)$d) . '<br>');
        $records = count((array)$d);
        for ($i=0; $i < $records; $i++) {
                //print('Contact ID: ' . $d[$i]->contactId . '<br>');
        }
    ?></h4>
    
<?php require APPROOT . '/views/inc/footer.php'; ?>
