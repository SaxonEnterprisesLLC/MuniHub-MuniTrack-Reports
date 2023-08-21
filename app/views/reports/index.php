<?php require APPROOT . '/views/inc/header.php'; ?>
    <?php flash('post_message'); ?>
    
    <div class="row">
        <div class="col-md-6">
            <h1>Reports</h1>
        </div>
        <br/>
        <hr>
        <div class="dropdown">
            <h3>Hello <?php echo $_SESSION['user_name']; ?> from <?php echo $data['companyName']; ?></h3>
            <h4>MuniHub Deal Campaign Reports</h4>
            <select id="campaigns" class="form-select form-select-lg mb-3" aria-label="MuniHub Deal Campaign Reports">
                <option value="">-- Select Deal Campaign --</option>
            </select>
            <br>
            <div class="card" id="campaignsCard">
                <div class="card-body">
                    <p id="deal" class="card-title">This is what MuniHub Campaign ID you selected: <br>
                        <span id="campaignOutput"></span>
                    <hr>
                    <div id="runReport" class="col-md-6">
                        <a href="<?php echo URLROOT; ?>/reports/run" class="btn btn-primary">
                        <i class="fa fa-pencil"></i>  Run the Report</a>
                    </div>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
    
   <div>
        <!-- Grab data from $S_SESSION in PHP -->
        <script type="text/javascript">

            let Campaigns = <?php echo json_encode($_SESSION['clientCampaigns']); ?>;
            //console.log('ClientCampaigns', Campaigns);
            let campaignID = 0;
            let campaignName = '';
            campaigns = document.getElementById('campaigns');

            for (campaign in Campaigns) {
                    let selection = document.createElement('option');
                    selection.innerHTML = Campaigns[campaign].campaignName;
                    selection.value = parseInt(Campaigns[campaign].campaignId);
                    campaigns.appendChild(selection);
            }

            campaigns.addEventListener('change', e => {
                campaignOutput.innerHTML = e.target.value;
                for (campaign in Campaigns) {
                    if (e.target.value == Campaigns[campaign].campaignId) {  
                        campaignName = Campaigns[campaign].campaignName;
                        campaignOutput.innerHTML += ' ===> ' + Campaigns[campaign].campaignName;
                        console.log(e.target.value, ' ==== ' , campaignName);
                        campaignID = e.target.value;
                        sessionStorage.setItem('campaignID', e.target.value);
                        sessionStorage.setItem('campaignName', campaignName);
                        createCookie("campaignID", campaignID, "");
                        document.getElementById('runReport').style.display = "block";
                        return
                    }
                    
                }
                
            })

        </script>

    </div>
    
<?php require APPROOT . '/views/inc/footer.php'; ?>
