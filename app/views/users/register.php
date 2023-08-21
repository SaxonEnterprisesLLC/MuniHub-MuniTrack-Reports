<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create An Account</h2>
                <p>Please fill out this form to register with us</p>
                <form action="<?php echo URLROOT; ?>/users/register" method="post">
                    <div class="form-group">
                        <label for="name">Name: <sup>*</sup></label>
                        <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['nameErr'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                        <span  class="invalid-feedback"><?php echo $data['nameErr']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="company">Company: <sup>*</sup></label>
                        <select id="company" name="company" class="form-select form-select-lg mb-3" aria-label="MuniHub Deal Clients" <?php echo (!empty($data['companyErr'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['company']; ?>">
                        <option value="">-- Select a MuniHub Client --</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['companyErr']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['emailErr'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['emailErr']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" autocomplete="on" class="form-control form-control-lg <?php echo (!empty($data['passwordErr'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['passwordErr']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password: <sup>*</sup></label>
                        <input type="password" name="confirmPassword" autocomplete="on" class="form-control form-control-lg <?php echo (!empty($data['confirmPasswordErr'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirmPassword']; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirmPasswordErr']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-success btn-block"> 
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                        </div>
                    </div>
                </form>
                <script type="text/javascript">

                    let selectedClient;

                    let OMClients = <?php echo json_encode($_SESSION['OMClients']); ?>;
                    const company = document.getElementById("company");

                
                    console.log('Clients', OMClients);

                    for (let client in OMClients) {
                            let selection = document.createElement('option');
                            selection.innerHTML = OMClients[client].clientName;
                            selection.value = OMClients[client].clientId;
                            document.getElementById('company').appendChild(selection);
                    }

                    company.addEventListener('change', e => {
                        let selectedClient = e.target.value;
                        console.log('hello', selectedClient);
                    })
                
                </script>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
