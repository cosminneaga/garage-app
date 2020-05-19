<?php
    if(!defined('navigation')){
        header('location: index.php');
    }else{ ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="dashboard.php">~ <?php echo $username ?> ~</a>
    <button class="navbar-toggler" type="button" id="navbar-button" onclick="navbarShowHide()">
        <img src="../pictures/menu.png" alt="" class="navbar-toggler-icon">
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">Dashboard<span class="sr-only">(current)</span></a>
            </li>
            <li>
                <a type="button" class="nav-link" data-toggle="modal" data-target="#add-new-user">USER +</a>
            </li>
            <li>
                <a class="nav-link" href="comments.php">Comments</a>
            </li>
            <li>
                <a class="nav-link" href="survey_statistics.php">Survey Statistics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<?php   }
?>