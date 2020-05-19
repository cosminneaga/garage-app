<?php
if(!defined('modal')){
    header('location: index.php');
}else{
?>

<!-- ADD NEW USER MODAL -->
<div class="modal fade" id="add-new-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form" class="border border-dark p-3" onsubmit="return false;">
                            <div class="form-group">
                                <label>Unique Username</label>
                                <input type="text" id="username" class="form-control" placeholder="Username" onkeyup="userCheck(this.value)" required>
                                <div class="invalid-feedback">Username Exists Already</div>
                            </div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" id="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label>E-Mail Address</label>
                                <input type="email" id="email" class="form-control" placeholder="E-Mail" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="pass" class="form-control" placeholder="Password" onkeyup="checkUserPassword()" onblur="checkPassword()" required>
                            </div>
                            <div class="form-group">
                                <label>Verify Password</label>
                                <input type="password" id="passchk" class="form-control" placeholder="Password" onkeyup="checkUserPassword(this.value)" required>
                                <div class="invalid-feedback">Passwords don't match</div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-primary" id="button">Submit</button>
                                <div id="success" class="text-success p-1"></div>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>

<?php
}
?>