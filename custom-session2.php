<?php
    session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Matthew Compelube
    last modified: 05-4-18
-->

<head>
    <title> Tea Rex </title>
    <meta charset="utf-8" />

    <?php
    /* these are bringing in needed PHP functions */
    
        require_once("create_login.php");
        require_once("create-choice.php");
        require_once("display.php");
        require_once("destroy_and_exit.php");
        require_once("hsu_conn_sess.php");
		require_once("create_tea_dropdown.php");
		require_once("custom_table.php");
		require_once("create_sale_dropdown.php");
		require_once("employee-table.php");
		require_once("create_insert_form.php");
		require_once("insert-table.php");
    ?>

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />
	<link href="custom.css"
	      type="text/css" rel="stylesheet" />
	<script src="custom.js" type="text/javascript" async="async">
    </script>
</head>

<body>
    <h1> Matthew Compelube </h1>
	<h2> CS 328 </h2>
	<h2> Tea Rex </h2>

    <?php
    if (! array_key_exists('next-stage', $_SESSION))
    {
        create_login();
        $_SESSION['next-stage'] = "create_choice";
    }
    elseif ($_SESSION['next-stage'] == "create_choice")
    {
        create_choice(); 
        $_SESSION['next-stage'] = "display";
    }
	elseif ($_SESSION['next-stage'] == "create_repeat_choice")
	{
		create_repeat_choice();
		$_SESSION['next-stage'] = "display";
	}
    elseif ($_SESSION['next-stage'] == "display")
    {
		if ($_POST["options"] == 'custom-table')
		{
			create_tea_dropdown();
			$_SESSION['next-stage'] = "menu";
		}
		elseif ($_POST["options"] == 'employee-table')
		{
			create_sale_dropdown();
			$_SESSION['next-stage'] = "info";
		}
		elseif ($_POST["options"] == 'insert-table')
		{
			create_insert_form();
			$_SESSION['next-stage'] = "hire";
		}
		elseif(array_key_exists('another_one', $_POST))
		{
			create_repeat_choice();
			$_SESSION['next-stage'] = "display";
		}
		elseif(array_key_exists('logout', $_POST))
		{
			session_destroy();
			session_regenerate_id(TRUE);
			session_start();
     
			create_login();
			$_SESSION['next-stage'] = "create_choice";
			
		}
		else
		{
			//session_destroy();
			$_SESSION['next-stage'] = "create_repeat_choice";
		}
    }
	elseif ($_SESSION['next-stage'] == "menu")
	{
		custom_table();
		$_SESSION['next-stage'] = "create_repeat_choice";
	}
	elseif ($_SESSION['next-stage'] == "info")
	{
		employee_table();
		$_SESSION['next-stage'] = "create_repeat_choice";
	}
	elseif ($_SESSION['next-stage'] == "hire")
	{
		insert_table();
		$_SESSION['next-stage'] = "create_repeat_choice";
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
        $_SESSION['next-stage'] = "create_choice";
    }
	
	?>
	<br />
	<a href="http://nrs-projects.humboldt.edu/~mac1782/hw12/custom-session2.php">
	<strong> RETURN LINK </strong> </a>
	
	<?php
	
    require_once("328footer.html");
?>

</body>
</html>
   

