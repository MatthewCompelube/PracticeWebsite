<?php
/*=====
    function: employee_table: void -> void
    purpose: expects nothing, and returns nothing, BUT does
        expect the $_POST array to contain a key "username"
        with a valid Oracle username, and a key "password"
        with a valid Oracle password;
      
        ...if it cannot find these, or if it cannot make a
        valid connection to Oracle using these, it 
        destroys the session and exits;

        ...otherwise, it tries to output to the resulting
        document a table showing employee information.

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function employee_table()
{
    if ( (! array_key_exists("sales", $_POST)) or
         ($_POST["sales"] == "") or
         (! isset($_POST["sales"])) )
    {
        destroy_and_exit("Must select a sale");
    }

    // if reach here, DO have a username and password; 

    // $username = strip_tags($_SESSION["username"]);
    // $password = strip_tags($_SESSION["password"]);
	$sale_id     = strip_tags($_POST["sales"]);

	// $_SESSION["username"] = $username;
    // $_SESSION["password"] = $password;
	$_SESSION["sales"] = $sale_id;
	
    $conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]);

    // if reach here -- CONNECTED!
	
	$empl_call = 'begin :id := empl_info(:sale_id); end;';

    $empl_stmt = oci_parse($conn, $empl_call);

    oci_bind_by_name($empl_stmt, ":sale_id", 
                         $sale_id); 
    oci_bind_by_name($empl_stmt, ":id",
                         $empl_id, 10);

    oci_execute($empl_stmt, OCI_DEFAULT);
	oci_free_statement($empl_stmt);

    $info_str = "select empl_fname, empl_lname, empl_phone
                       from employee
                       where empl_id = :employee_id";
	$info_stmt = oci_parse($conn, $info_str);
	
	
	oci_bind_by_name($info_stmt, ":employee_id", $empl_id);
    oci_execute($info_stmt);
	oci_fetch($info_stmt);
	$first_name = oci_result($info_stmt, "EMPL_FNAME");
	$last_name = oci_result($info_stmt, "EMPL_LNAME");
	$phone_num = oci_result($info_stmt, "EMPL_PHONE");
	
	?>
	
	<h3> Employee who served order </h3>
	<strong> Name: <?= $first_name ?> <?= $last_name ?> </strong> <br />
	<strong> Phone #: <?= $phone_num ?> </strong> <br />
	
	<br />
	
	<form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
			<input type="submit" name="another_one" 
		       id="another_one" value="Another action?" />
			<input type="submit" name="logout"
			       id="logout" value="Logout" />
        </fieldset>
    </form>
	
	<?php

    oci_free_statement($info_stmt);
	
    oci_close($conn);
}

?>