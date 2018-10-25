<?php
/*=====
    function: create_tea_dropdown: void -> void
    purpose: expects nothing, and returns nothing, BUT does
        expect the $_POST array to contain a key "username"
        with a valid Oracle username, and a key "password"
        with a valid Oracle password;
      
        ...if it cannot find these, or if it cannot make a
        valid connection to Oracle using these, it 
        destroys the session and exits;

        ...otherwise, it tries to output to the resulting
        document a dynamically-created dropdown with the current
        tea item names

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function create_insert_form()
{
    // first: IS there at least an attempt at a username/password?

    // if ( (! array_key_exists("username", $_POST)) or
         // (! array_key_exists("password", $_POST)) or
         // ($_POST["username"] == "") or
         // ($_POST["password"] == "") or
         // (! isset($_POST["username"])) or
         // (! isset($_POST["password"])) )
    // {
        // destroy_and_exit("must enter a username and password!");
    // }

    // if reach here, DO have a username and password; 

    // $username = strip_tags($_POST["username"]);

    // ONLY using password to log in, so NOT sanitizing it (gulp?)
    
    // $password = strip_tags($_POST["password"]);

    // save these for later (should be OK to do now, I THINK, because if
    //     connection fails, WILL be destroying session, and these,
    //     later)
    
    // $_SESSION["username"] = $username;
    // $_SESSION["password"] = $password;

    //   NOW: can you connect to Oracle with them?
    //     (NOTE that hsu_conn_sess destroys session and
    //     exits the PHP document if it fails...!)

    $conn = hsu_conn_sess($_SESSION['username'], $_SESSION['password']);

    // if reach here -- CONNECTED!

    $empl_query_str = "select max(empl_id)
                                   from employee";
    $empl_query = oci_parse($conn, $empl_query_str);
    oci_execute($empl_query);
	oci_fetch($empl_query);
	$max_id = oci_result($empl_query, "MAX(EMPL_ID)");
    // build a form with a dropdown
	$max_id = $max_id + 1;
	$_SESSION["max_id"] = $max_id;

    ?>
    <form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
            <legend> Enter new employee information </legend>
			
			Employee ID #: <em> <?= $max_id ?> </em> <br />
			<label for="firstname"> First Name:
			<input type="text" name="fname"
			       id="firstname" required="required" /> </label>
			<label for="lastname"> Last Name:
			<input type="text" name="lname"
				   id="lastname" required="required" /> </label> <br />
			<strong> Employee discount 30% </strong> <br />
			<label for="emplsalary"> Salary:
			<input type="text" name="salary"
				   id="emplsalary" maxlength="6" 
				   required="required" /> </label>
			<br />
			<label for="phonenum"> Phone Number:
			<input type="text" name="phone" 
			       id="phonenum" maxlength="10" 
				   required="required" /> </label>
			<br />
			
        </fieldset>
        <input type="submit" value="Hire!" />
		<br />
    </form>
	
	<br />

    <?php
    oci_free_statement($empl_query);
    oci_close($conn);
}

?>