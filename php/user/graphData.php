<?php
require('auth.php');
define('functions',TRUE);
require('functions.php');
    if(isset($_SERVER['HTTP_REFERER'])){
        $extract = new extract();
        if(isset($_GET['today-inv'])){
            $t_date = $_GET['today-inv'];
            $today = $extract->graphs_data_invoices_by_date($conn, $ownedBy_S, $t_date);
            echo $today;
        }

        if(isset($_GET['yesterday'])){
            $yes_date = $_GET['yesterday'];
            $yesterday = $extract->graphs_data_invoices_by_date($conn, $ownedBy_S, $yes_date);
            echo $yesterday;
        }

        if(isset($_GET['this-month'])){
            $tm_date = $_GET['this-month'];
            $this_month = $extract->graphs_data_invoices_by_date($conn, $ownedBy_S, $tm_date);
            echo $this_month;
        }

        if(isset($_GET['last-month'])){
            $lm_date = $_GET['last-month'];
            $last_month = $extract->graphs_data_invoices_by_date($conn, $ownedBy_S, $lm_date);
            echo $last_month; 
        }

        if(isset($_GET['yearly'])){
            $y_date = $_GET['yearly'];
            $yearly = $extract->graphs_data_invoices_by_date($conn, $ownedBy_S, $y_date);
            echo $yearly; 
        }

    }
?>