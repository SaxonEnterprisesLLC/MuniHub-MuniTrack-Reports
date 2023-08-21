<?php require APPROOT . '/views/inc/header.php'; ?>
    <?php flash('post_message'); ?>
    <a href="<?php echo URLROOT; ?>/reports" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
    <div class="row">
        <div class="col-md-6">
            <h2>MuniHub Reports</h2>
        </div>
        <hr>
        <div class="col-md-12" id="h3color">
            <h3>Hello <?php echo $_SESSION['user_name']; ?> from <?php echo $_SESSION['companyName']; ?></h3>
            <h4 id="reportInfo"></h4>
        </div>
    </div>
    <div class="container">
        <img src=<?php echo URLROOT . '/public/img/MuniHubTrackReportLogo.png'; ?> />
        <hr width="80%"><br/>
        <div id="displayCampaignDetails"></div>
        
        <hr width="80%">
        <br/>
        <div class="container text-center">
            <div class="row row-cols-2">
                <div class="col" >
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <p>Distribution Results</p>
                                </th>
                                <th class="viewHeader">
                                    <p>Views</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="displayOMSummary" ></tbody>
                    </table>
                </div>
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <p>Sector Results</p>
                                </th>
                                <th class="viewHeader">
                                    <p>Views</p>
                                </th>
                                <th class="viewHeader">
                                    <p>Clicks</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="displayCampaignActivity" ></tbody>
                    </table>
                </div>
                <div class="col"><canvas id="DistResults" style="width:100%;max-width:600px"></canvas></div>
                <div class="col" id="sectorGraphs">
                    <canvas id="SectorViews" style="width:100%;max-width:275px"></canvas>
                    <canvas id="SectorClicks" style="width:100%;max-width:275px"></canvas>
                    <!-- <canvas id="SectorViews"></canvas>
                    <canvas id="SectorClicks"></canvas> -->
                </div>
            </div>
        </div>
        <div><h4>Detailed Distribution Results</h4></div>
        <div id="displayContactInfo">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Company</th>
                    <th scope="col">Sector</th>
                    <th scope="col">Total Views</th>
                    <th scope="col">Total Clicks</th>
                </tr>
                </thead>
                <tbody id="contactInfo">
                
                </tbody>           
            </table>
        </div>

    <script type="text/javascript">

        const campaignId = sessionStorage.getItem('campaignID');
        const campaignName = sessionStorage.getItem('campaignName');
        document.querySelector('#reportInfo').innerHTML = 'Running the report for Campaign ' + campaignId + ' : ' + campaignName;
    
        function displayClientCampaigns(campaignId) {
    
            let d = <?php echo json_encode($_SESSION['campaigns']); ?>;
            
            let campaignList = [];
            let campaignType = "";
            for (let i=0; i < d.length; i++) {
                if (d[i].campaignId == campaignId) {
                    
                    campaignList.unshift(d[i].campaignName);
                    //campaignList.unshift(d[i].subject);
                    campaignList.unshift(d[i].status);
                    campaignList.unshift(d[i].sentDate.slice(0,10));
                    campaignList.unshift(d[i].dealId);

                    if (d[i].campaignName.substr(-4,).localeCompare("(ID)") === 0 ) {
                        campaignType = d[i].campaignName.slice(-4, );
                        campaignList.unshift(campaignType);
                        campaignList.unshift(d[i].campaignSubject.slice(11,));
                    } else if (d[i].campaignName.substr(-5,).localeCompare("(DOS)") === 0 ) {
                        campaignType = d[i].campaignName.slice(-5, );
                        campaignList.unshift(campaignType);
                        campaignList.unshift(d[i].campaignSubject.slice(15,));
                    } else {
                        campaignType = "NO"
                        campaignList.unshift(campaignType);
                    }
                    break;
                }
            }
    
            muniCard = `${campaignList[2]}`;
            let html = `<h4>${campaignList[0]} - ${campaignList[1]}</h4>
            <p>MuniCard: ${campaignList[2]} - Sent ${campaignList[3]}</p>`;
            document.querySelector('#displayCampaignDetails').innerHTML = html;
        }

        function displayOMCampaignSummary() {

            let d = <?php echo json_encode($_SESSION['OMCampaignSummary']); ?>;
            
            //console.log("Campaign Email Summary", d);
            //let campaignName = CampaignID;
            let numTotalSent = d.totalSent;
            let numTotalUniqueOpens = d.totalUniqueOpens;
            let numTotalOpens = d.totalOpens;
            let numTotalClicks = d.totalClicks;

            let html = `
                    <tr>
                        <td>Total Emails Delivered</td>
                        <td>${numTotalSent}</td>
                    <tr>
                    <tr>
                        <td>Total Unique Views</td>
                        <td>${numTotalUniqueOpens}</td>
                    <tr>
                    <tr>
                        <td>Total Views</td>
                        <td>${numTotalOpens}</td>
                    <tr>
                    <tr>
                        <td>Total Clicks to the MuniCard</td>
                        <td>${numTotalClicks}</td>
                    <tr>
                </tbody>`;

            document.querySelector('#displayOMSummary').innerHTML = html;

            iterations = <?php echo json_encode($_SESSION['interval']); ?>;
            //console.log( iterations);
            let xValues = ["Total Unique Opens", "Total Opens", "Total Clicks","Total Sent" ];
            let yValues = [numTotalUniqueOpens, numTotalOpens, numTotalClicks,numTotalSent];
            let barColors = ["purple", "green","blue","orange"];
            new Chart("DistResults", {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues,
                        label: "Campaign Data"

                    }]
                },
                options: {
                    legend: {display: false},
                    title: {
                        display: true,
                        text: `Distribution Results for MuniCard ${muniCard}`,
                        font: {size: 20},
                    },
                },
            });

        }

        const displayCampaignContactsData = () => {

            let contactData = <?php echo json_encode($_SESSION['OMData']); ?>;
            let OMcontacts = <?php echo json_encode($_SESSION['campaignContactData']); ?>;
            
            console.log("Campaign OMData", contactData);
            console.log("Campaign Contact Data", OMcontacts);
            //console.log(contactData.length);
            //console.log(OMcontacts[0]);
            let contact;
            let numOpens;
            let numClicks;
            let company;
            let sector;
            let role;
            let OMcontactInfo = [];
            let contactInfo = [];
            let contactObj = [];
            let notInListObj = [];
            let notInList = [];
            
            for (let i=0; i < contactData.length; i++) {
                for (let j=0; j < OMcontacts.length; j++) {  
                    if ((OMcontacts[j].contactId == contactData[i].contactId) && ((contactData[i].numOpens > 0) || (contactData[i].numClicks > 0)))
                    {
                        contactObj = [{
                            contactId:contactData[i].contactId,
                            numOpens:contactData[i].numOpens,
                            numClicks:contactData[i].numClicks,
                            company:OMcontacts[j].company,
                            sector:OMcontacts[j].sector,
                            role:OMcontacts[j].role
                        }];
                        //console.log(contactObj);
                        contactInfo.push(...contactObj);
                    }
                } 
            }
            console.log(contactInfo.length);
            //console.log(contactInfo);
            //console.log("Not in List: ", notInList);
            
            let uniqueCompanies = contactInfo.map(item => item.company).filter((value, index, self) => self.indexOf(value) === index);
            
            //
            uniqueCompanies = uniqueCompanies.sort();
            let index = uniqueCompanies.indexOf("MuniHub");
            const x = uniqueCompanies.splice(index,1);
            index = uniqueCompanies.indexOf("");
            const y = uniqueCompanies.splice(index,1);
            //console.log(x, y);
            //console.log(uniqueCompanies);
            
            let opens = 0;
            let clicks = 0;
            let OMReportDataObj = [];
            let OMReportData = [];
            let totalOpens = 0;
            let totalClicks = 0;
            let totalBrokerDealer = 0;
            let totalBrokerDealerOpens = 0;
            let totalBrokerDealerClicks = 0;
            let totalBuyside = 0;
            let totalBuysideOpens = 0;
            let totalBuysideClicks = 0;
            let totalOther = 0;
            let totalOtherOpens = 0;
            let totalOtherClicks = 0;
            let buyside = "Buyside";
            let brokerDealer = "Broker-Dealer";
            let other = "Financial News Service/Other";
            
            for (let i=0; i < contactInfo.length; i++) {       
                if (contactInfo[i].sector === buyside) {
                        totalBuysideOpens += contactInfo[i].numOpens, 
                        totalBuysideClicks += contactInfo[i].numClicks
                } else if (contactInfo[i].sector === brokerDealer) {
                        totalBrokerDealerOpens += contactInfo[i].numOpens, 
                        totalBrokerDealerClicks += contactInfo[i].numClicks
                } else if (contactInfo[i].sector === other) {
                        totalOtherOpens += contactInfo[i].numOpens, 
                        totalOtherClicks += contactInfo[i].numClicks
                };
            }
            
            let html = `
                    <tr>
                        <td>Buyside</td>
                        <td>${totalBuysideOpens}</td>
                        <td>${totalBuysideClicks}</td>
                    <tr>
                    <tr>
                        <td>Broker Dealer</td>
                        <td>${totalBrokerDealerOpens}</td>
                        <td>${totalBrokerDealerClicks}</td>
                    <tr>
                    <tr>
                        <td>Financial News Service</td>
                        <td>${totalOtherOpens}</td>
                        <td>${totalOtherClicks}</td>
                    <tr>
                </tbody>`;
            
            document.querySelector('#displayCampaignActivity').innerHTML = html;
            
            let xValues = ["Buyside Opens", "Broker Dealer Opens", "Financial News Open"];
            let yValues = [totalBuysideOpens, totalBrokerDealerOpens, totalOtherOpens];
            let barColors = ["red", "green","blue"];
            new Chart("SectorViews", {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Views by Sector',
                            //font: {size: 20},
                        },
                    },
                },
            });
            
            let xxValues = ["Buyside Opens", "Broker Dealer Opens", "Financial News Open"];
            let yyValues = [totalBuysideClicks, totalBrokerDealerClicks, totalOtherClicks];
            new Chart("SectorClicks", {
                type: "pie",
                data: {
                    labels: xxValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yyValues
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Clicks by Sector',
                            //font: {size: 20},
                        },
                    },
                },
            });
            
            for (let i=0; i < uniqueCompanies.length; i++) {
                for (let j=0; j < contactInfo.length; j++) { 
                    if (uniqueCompanies[i] === contactInfo[j].company) {
                            sector = contactInfo[j].sector,
                            opens += contactInfo[j].numOpens, 
                            clicks += contactInfo[j].numClicks
                    };  
                }   
                OMReportDataObj = [{
                            company:uniqueCompanies[i],
                            sector:sector,
                            totalOpens:opens, 
                            totalClicks:clicks
                        }];  
                OMReportData.push(...OMReportDataObj);
            
                //console.log(uniqueCompanies[i], "Role: ", role, "Sector:", sector, "Opens: ", opens, "Clicks: ",clicks);
                opens = 0;
                clicks = 0;
            }
            //console.log(OMReportData); 
            
            let table_body = document.querySelector("#contactInfo");
            
            for (let i=0; i < OMReportData.length; i++) {
                //console.log(OMReportData[i].company);
                let row = `<tr>
                    <td>${[i+1]}</td>
                    <td>${OMReportData[i].company}</td>
                    <td>${OMReportData[i].sector}</td>
                    <td>${OMReportData[i].totalOpens}</td>
                    <td>${OMReportData[i].totalClicks}</td>
                    </tr>`;
                table_body.innerHTML += row;
            }

            
                
        };

        displayClientCampaigns(campaignId);
        displayOMCampaignSummary();
        displayCampaignContactsData();
    
    </script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
