<?php
/*=====
    function: display: void -> void
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

function display()
{
    if ( (! array_key_exists("titles", $_POST)) or
         ($_POST["titles"] == "") or
         (! isset($_POST["titles"])) )
    {
        destroy_and_exit("must select a isbn and quantity");
    }

    // if reach here, DO have a username and password; 

    $username = strip_tags($_SESSION["username"]);
    $password = strip_tags($_SESSION["password"]);
	$a_isbn     = strip_tags($_POST["titles"]);
	$qty      = strip_tags($_POST["qty"]);

    // save these for later (should be OK to do now, I THINK, because if
    //     connection fails, WILL be destroying session, and these,
    //     later)
	
    //   NOW: can you connect to Oracle with them?
    //     (NOTE that hsu_conn_sess destroys session and
    //     exits the PHP document if it fails...!)

	$_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
	$_SESSION["isbn"] = $a_isbn;
	$_SESSION["qty"] = $qty;
	
    $conn = hsu_conn_sess($username, $password);

    // if reach here -- CONNECTED!
	
	// $order_call = 'begin insert_order_needed(:a_isbn, :a_qty); end;';
	
	// $order_stmt = oci_parse($conn, $order_call);
	
	// oci_bind_by_name($order_stmt, ":a_isbn",
	                  // $a_isbn);
    // oci_bind_by_name($order_stmt, "a_qty",
					  // $qty);
	
	// oci_execute($order_stmt, OCI_DEFAULT);
	//oci_commit($conn);
	// oci_free_statement($order_stmt);

    $order_chg_str = "select pub_name, title_name, author, title_price 
                       from title, publisher
                       where title.pub_id = publisher.pub_id
					   and isbn = :a_isbn";
	$order_chg_stmt = oci_parse($conn, $order_chg_str);
	
	
	oci_bind_by_name($order_chg_stmt, ":a_isbn", $a_isbn);
    oci_execute($order_chg_stmt);
	oci_fetch($order_chg_stmt);
	//$the_isbn = oci_result($order_chg_stmt, "ISBN");
	//$the_qty = oci_result($order_chg_stmt, "ORDER_QTY");
	$the_publisher = oci_result($order_chg_stmt, "PUB_NAME");
	$the_title = oci_result($order_chg_stmt, "TITLE_NAME");
	$the_author = oci_result($order_chg_stmt, "AUTHOR");
	$the_price = oci_result($order_chg_stmt, "TITLE_PRICE");
	$subtotal = $the_price * $qty;
	$tax = $the_price * $qty * .085;
	$total_price = $the_price + ($the_price * $qty * .085);
	?>
	
	<h3> Order Details </h3>
	
	<form action="<?= htmlentities($_SERVER['PHP_SELF'],
                                       ENT_QUOTES) ?>"
          method="post"
          id="orderForm">
		<fieldset>
        
			<strong> Publisher: <?= $the_publisher ?> </strong> <br />
			<strong> Title: <?= $the_title ?> </strong> <br />
			<strong> Author: <?= $the_author ?> </strong> <br />
			<strong> Price: $<?= $the_price ?> </strong> <br />
			<strong> Quantity: <?= $qty ?> </strong> <br />
			<strong> Subtotal: $<?= round($subtotal,2) ?> </strong> <br />
			<strong> Tax: $<?= round($tax,2) ?> </strong> <br />
			<strong> Total Price: $<?= round($total_price,2) ?> </strong> <br />
		
		</fieldset>
		<input type="submit" name="cancel"
		       id="cancel" value="Cancel" />
		<input type="submit" name="continue"
		       id="continue" value="Continue" />
    </form>
	
	
	<?php

    oci_free_statement($order_chg_stmt);
	
    oci_close($conn);
}

?>