<?php
/*=====
    function: custom_table: void -> void
    purpose: expects nothing, and returns nothing, BUT does
        expect the $_POST array to contain a key "username"
        with a valid Oracle username, and a key "password"
        with a valid Oracle password;
      
        ...if it cannot find these, or if it cannot make a
        valid connection to Oracle using these, it 
        destroys the session and exits;

        ...otherwise, it tries to output to the resulting
        document a table showing a order has been submitted

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function custom_table()
{
    if ( (! array_key_exists("teas", $_POST)) or
         ($_POST["teas"] == "") or
         (! isset($_POST["teas"])) )
    {
        destroy_and_exit("Must select a tea!!!");
    }

    // if reach here, DO have a username and password; 

    // $username = strip_tags($_SESSION["username"]);
    // $password = strip_tags($_SESSION["password"]);
	$tea_id     = strip_tags($_POST["teas"]);

    // save these for later (should be OK to do now, I THINK, because if
    //     connection fails, WILL be destroying session, and these,
    //     later)
	
    //   NOW: can you connect to Oracle with them?
    //     (NOTE that hsu_conn_sess destroys session and
    //     exits the PHP document if it fails...!)

	// $_SESSION["username"] = $username;
    // $_SESSION["password"] = $password;
	$_SESSION["tea"] = $tea_id;
	
    $conn = hsu_conn_sess($_SESSION['username'], $_SESSION['password']);

    // if reach here -- CONNECTED!

    $tea_str = "select item_price, item_name 
                       from sale_item
                       where item_id = :tea_id";
	$tea_stmt = oci_parse($conn, $tea_str);
	
	
	oci_bind_by_name($tea_stmt, ":tea_id", $tea_id);
    oci_execute($tea_stmt);
	oci_commit($conn);
	oci_fetch($tea_stmt);
	$the_price = oci_result($tea_stmt, "ITEM_PRICE");
	$the_name = oci_result($tea_stmt, "ITEM_NAME");
	
	oci_free_statement($tea_stmt);
	
	$tea_table_str = "select tea_brand, tea_method, tea_type 
						       from tea
                               where item_id = :tea_table_id";
	$tea_table_stmt = oci_parse($conn, $tea_table_str);
	
	
	oci_bind_by_name($tea_table_stmt, ":tea_table_id", $tea_id);
    oci_execute($tea_table_stmt);
	oci_commit($conn);
	oci_fetch($tea_table_stmt);
	$the_brand = oci_result($tea_table_stmt, "TEA_BRAND");
	$the_method = oci_result($tea_table_stmt, "TEA_METHOD");
	$the_type = oci_result($tea_table_stmt, "TEA_TYPE");
	oci_free_statement($tea_table_stmt);
	
	?>
	
	<h2> Tea Price </h2>
	<strong> Tea Name: <?= $the_name ?> </strong> <br />
	<strong> Tea Brand: <?= $the_brand?> </strong> <br />
	<strong> Brewing Method: <?= $the_method?> </strong> <br />
	<strong> Tea Type: <?= $the_type ?> </strong> <br />
	<strong> Tea Price: $<input type="text" name="price"
									 id="price" value="<?= $the_price ?>" 
									 size="2"/> </strong> <br />
	<strong> Hot & Ready </strong> <br />
	<br />
	
	<fieldset>
		<button id="discount"> Show With Employee Discount </button> <br />
		<strong><p id="empl_discount"></p> </strong>
	</fieldset>
	
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
	
    oci_close($conn);
}

?>