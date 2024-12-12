<?php

  $a_id = $_SESSION['a_id'];

  $a_name = $_SESSION['a_name'];

  $a_status = $_SESSION['a_status'];

 	if($a_status!='1'){

    Header("Location:logout");  

  }  

  ?>