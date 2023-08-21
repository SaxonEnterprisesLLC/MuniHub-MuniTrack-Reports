<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>   
    <div class="card card-body bg-light mt-5">
        <h2>Edit Quote</h2>
        <p>Edit the Quote</p>
        <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">
            <div class="form-group">
                <label for="title">Title: <sup>*</sup></label>
                <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['titleErr'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                <span class="invalid-feedback"><?php echo $data['titleErr']; ?></span>
            </div>
            <div class="form-group">
                <label for="body">Your Quote: <sup>*</sup></label>
                <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['bodyErr'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
                <span class="invalid-feedback"><?php echo $data['bodyErr']; ?></span>
            </div>
            <input type="submit" value="Submit" class="btn btn-success m-2">   
        </form>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>