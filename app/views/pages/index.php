<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-3"><?php echo $data['title']; ?></h1>
            <div class="lead"><?php echo $data['description']; ?></div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>