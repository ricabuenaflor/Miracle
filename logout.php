<?php 
require_once 'include/initialize.php';

@session_start();


unset( $_SESSION['CUSID']);
// unset( $_SESSION['USERID'] );
unset( $_SESSION['CUSNAME'] );
unset( $_SESSION['CUSUNAME'] );
unset( $_SESSION['CUSUPASS'] ); 
unset($_SESSION['gcCart']);
unset($_SESSION['gcCart']);
unset( $_SESSION['fixnmixConfiremd']);
unset($_SESSION['gcNotify']);
unset($_SESSION['orderdetails']);


redirect("index.php?logout=1");
?> 	 