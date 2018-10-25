<?php
    session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Matthew Compelube
    last modified: 04-20-18
-->

<head>
    <title> Sell Book </title>
    <meta charset="utf-8" />

    <?php
    /* these are bringing in needed PHP functions */
    
        require_once("create_login.php");
        require_once("create_dropdown.php");
        require_once("display.php");
        require_once("destroy_and_exit.php");
        require_once("hsu_conn_sess.php");
		require_once("sell_book_function.php")
    ?>

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
	<link href="bks.css"
	      type="text/css" rel="stylesheet" />
	<script src="sellbook.js" type="text/javascript" async="async">
            </script>
		  
</head>

<body>
    <h2> Matthew Compelube </h2>
	<h2> CS 328 </h2>
	<h2> The Last Bookstore </h2>

    <?php
    if (! array_key_exists('next-stage', $_SESSION))
    {
        create_login();
        $_SESSION['next-stage'] = "create_dropdown";
    }
    elseif ($_SESSION['next-stage'] == "create_dropdown")
    {
        create_dropdown(); 
        $_SESSION['next-stage'] = "choice";
    }
    elseif ($_SESSION['next-stage'] == "display")
    {
        display();
        $_SESSION['next-stage'] = "choice";
    }
	elseif ($_SESSION['next-stage'] == "choice")
	{
		if (array_key_exists('cancel', $_POST))
		{
			create_session_dropdown();
			$_SESSION['next-stage'] = "choice";
		}
		elseif (array_key_exists('another_one', $_POST))
		{
			create_session_dropdown();
			$_SESSION['next-stage'] = "choice";
		}
		elseif (array_key_exists('submit', $_POST))
		{
			display();
			$_SESSION['next-stage'] = "choice";
		}
		elseif (array_key_exists('continue', $_POST))
		{
			sell_book();
			$_SESSION['next-stage'] = "choice";
		}
		else
		{
		session_destroy();
        session_regenerate_id(TRUE);
        session_start();
     
        create_login();
        $_SESSION['next-stage'] = "create_dropdown";
		}
	}
	
    else
    {
        ?>
        <p> <strong> YIKES! should NOT have been able to reach
            here! </strong> </p>
        <?php

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();
     
        create_login();
        $_SESSION['next-stage'] = "create_dropdown";
    }
	
	?>
	<br />
	<a href="http://nrs-projects.humboldt.edu/~mac1782/hw11/SellBook.php">
	<strong> Return Link </strong> </a>
	
	<?php
	
    require_once("328footer.html");
?>

</body>
</html>
   

