<?php

  $m_id = $_SESSION['m_id'];

  $m_username = $_SESSION['m_username'];

  $m_password = $_SESSION['m_password'];

  $m_status = $_SESSION['m_status'];

 	if($m_status!='1'){

    Header("Location:../logout");  

  }  

  ?>