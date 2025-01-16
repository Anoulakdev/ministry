<?php

  $m_id = $_SESSION['m_id'];

  $m_username = $_SESSION['m_username'];

  $m_status = $_SESSION['m_status'];

 	if($m_status!='1'){

    Header("Location:../logout");  

  }  

  ?>