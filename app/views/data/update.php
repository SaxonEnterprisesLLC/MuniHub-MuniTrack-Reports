<?php require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT; ?>/data" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
    <?php flash('post_message'); ?>
    <div class="row">
        <div class="col-md-6">
            <h1>OM Campaigns Update Testing</h1>
        </div>
        <div class="col-md-6">
            <a href="<?php echo URLROOT; ?>/data/update" class="btn btn-primary float-end">
            <i class="fa fa-pencil"></i>  Update Campaign Data</a>
        </div>
    </div>
    <div class="card card-body mb-3 col-sm-6">
    <p class="card-title"><?php 
        //print_r($data);
        //print('Total number of Campaigns in Query: ' . count($data['update']));
        print('Total number of Campaigns in Table: ' . $data['OMCampaignCount']->TotalCampaigns);
    ?>
    </p>
    </div>
    
<?php require APPROOT . '/views/inc/footer.php'; ?>