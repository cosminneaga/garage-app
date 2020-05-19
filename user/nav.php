<?php
if(!defined('nav'))
{
  header('Location: ../user-portal.php');
}
else
{
$extract = new extract();
$comp = $extract->company($conn, $ownedBy_S);
  ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border border-light rounded" id="nav">

<span class="navbar-brand text-uppercase">~ <a href="cpanel.php" class="text-warning font-italic card-link"><?php echo $username_S; ?></a> ~</span>

<button class="navbar-toggler" type="button" id="navbar-button" onclick="navbarShowHide()">
    <span class="navbar-toggler-icon"></span>
  </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                <li class="nav-item m-1 p-1">
                    <a class="nav-link bg-dark rounded-lg" href="cpanel.php">Home</a>
                </li>

                <?php
                  if($level == "manager")
                  {
                ?>
                <li class="nav-item m-1 p-1">
                    <button class="nav-link btn btn-outline-danger rounded-lg" onclick="window.location.href = 'uCreate.php';">Create User</button>
                </li>
                <li class="nav-item m-1 p-1">
                    <button class="nav-link btn btn-outline-danger rounded-lg" onclick="window.location.href = 'uView.php';">View Users</button>
                </li>
                <?php
                  }
                ?>

                <li class="nav-item m-1 p-1">
                    <button type="button" class="btn btn-link nav-link bg-dark rounded-lg" data-toggle="modal" data-target="#exampleModalCentered">
                    Profile
                    </button>
                </li>

                <li class="nav-item m-1 p-1">
                    <button class="nav-link bg-dark rounded-lg" onclick="window.location.href = 'dashboard.php';">Bookings</button>
                </li>

                <li class="nav-item m-1 p-1">
                    <button class="nav-link bg-dark rounded-lg" onclick="window.location.href = 'newclient.php';">Client +</button>
                </li>

                <li class="nav-item m-1 p-1">
                    <button class="nav-link bg-dark rounded-lg" onclick="window.location.href = 'newvehicle.php';">Vehicle +</button>
                </li>

                <li class="nav-item m-1 p-1">
                    <button class="nav-link bg-dark rounded-lg" onclick="window.location.href = 'newjob.php';">Invoice +</button>
                </li>

                <li class="nav-item m-1 p-1">
                    <button class="nav-link bg-dark rounded-lg" onclick="window.location.href = 'new-booking.php';">Booking +</button>
                </li>

                <li class="nav-item m-1 p-1">
                    <button class="nav-link bg-dark rounded-lg" onclick="window.location.href = 'activity.php';">Archive/Activity</button>
                </li>

                <?php
                  if($level == "manager"){
                    ?>
                    <li class="nav-item m-1 p-1">
                      <button class="nav-link btn btn-outline-danger rounded-lg" onclick="window.location.href = 'statistics.php';">Statistics</button>
                    </li>
                    <?php
                  }
                ?>

                <li class="nav-item m-1 p-1">
                  <button class="nav-link btn bg-dark rounded-lg" data-toggle="modal" data-target="#logoutModal">Log Out</button>
                </li>

            </ul>
            
        </div>

</nav>
<script src="../app/app.js?2"></script>



<!-- Modal: PROFILE -->
<div class="modal" id="exampleModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredLabel">Company Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row my-2">
          <div class="col-sm-4">
            Company Name:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['name']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
            Company E-Mail:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['email']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Address:
          </div>
          <div class="col-sm-8">
          <b><?php echo $comp['address']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          City:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['city']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Postcode:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['postcode']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Country:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['country']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Registration No.:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['registration_no']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Mobile:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['mob_one']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Mobile:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['mob_two']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Landline:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['landline']; ?></b>
          </div>
        </div>
        <div class="row my-2">
          <div class="col-sm-4">
          Tax Added Value:
          </div>
          <div class="col-sm-8">
            <b><?php echo $comp['tax_value']; ?>&nbsp;%</b>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?php
          if($level == "manager")
          {
            ?>
        <button type="button" class="btn btn-primary" onclick="window.location.href='profile.php'">Edit</button>
            <?php
          }
        ?>
      </div>
    </div>
  </div>
</div>
<!-- Modal: PROFILE ends -->




<!--Modal: LOGOUT-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
				<!--Content-->
				<div class="modal-content text-center bg-info-color-dark">
				<!--Header-->
				<div class="modal-header d-flex justify-content-center">
					<p class="heading">Are you sure you want to Log Out?</p>
				</div>

				<!--Body-->
				<div class="modal-body">

					<img src="../pictures/logout.png?1" alt="X-Image">

				</div>

				<!--Footer-->
				<div class="modal-footer flex-center">
					<a href="../php/user/logout.php" class="btn  btn-outline-danger">Yes</a>
					<a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
				</div>
				</div>
				<!--/.Content-->
			</div>
		</div>
<!--Modal: LOGOUT-->
  <?php
}
?>