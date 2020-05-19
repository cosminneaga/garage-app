<?php
if(!defined('footer'))
{
  header('Location: ../user-portal.php');
}
else
{
  ?>
<!-- Footer -->
<footer class="page-footer font-small bg-dark fixed-bottom"> 

  <!-- Copyright -->
  <div class="footer-copyright d-flex justify-content-around py-3 xbootstrap text-warning">
    <div>©<?php echo date("Y"); ?> Copyright:&nbsp;<i><a href="../user-portal.php">mygarageapp.net</a></i></div>
  </div>
  <!-- Copyright -->
  <div class="text-white"></div>
</footer>
<!-- Footer -->
  <?php
}
?>