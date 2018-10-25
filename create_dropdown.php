<?php
/*=====
    function: create_dropdown: void -> void
    purpose: expects nothing, and returns nothing, BUT does
        expect the $_POST array to contain a key "username"
        with a valid Oracle username, and a key "password"
        with a valid Oracle password;
      
        ...if it cannot find these, or if it cannot make a
        valid connection to Oracle using these, it 
        destroys the session and exits;

        ...otherwise, it tries to output to the resulting
        document a dynamically-created dropdown with the current
        isbn names and a quantity to be inserted

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function create_dropdown()
{
    // first: IS there at least an attempt at a username/password?

    if ( (! array_key_exists("username", $_POST)) or
         (! array_key_exists("password", $_POST)) or
         ($_POST["username"] == "") or
         ($_POST["password"] == "") or
         (! isset($_POST["username"])) or
         (! isset($_POST["password"])) )
    {
        destroy_and_exit("must enter a username and password!");
    }

    $username = strip_tags($_POST["username"]);

    $password = strip_tags($_POST["password"]);
    
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    //   NOW: can you connect to Oracle with them?
    //     (NOTE that hsu_conn_sess destroys session and
    //     exits the PHP document if it fails...!)

    $conn = hsu_conn_sess($username, $password);

    // if reach here -- CONNECTED!

    $title_query_str = "select isbn, title_name
                       from title
                       order by title_name";
    $title_query = oci_parse($conn, $title_query_str);
    oci_execute($title_query);

    // build a form with a dropdown

    ?>
    <form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
            <legend> Select Desired ISBN To Purchase</legend>
            <select name="titles">
            <?php
            while (oci_fetch($title_query))
            {
                $curr_isbn = oci_result($title_query, "ISBN");
                $curr_title_name = oci_result($title_query, "TITLE_NAME");
                ?>
                <option value="<?= $curr_isbn ?>"> 
                    <?= $curr_title_name ?>, <?= $curr_isbn ?> </option>
                <?php
            }
            ?>
            </select>
			<label> Quantity: <input type="text" name="qty" 
								     id="quantity" /> </label>
        </fieldset>
        <input type="submit" name="submit"
		       id="submit" value="submit choice" />  
    </form>
	
	</form>
	    <form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
			<input type="submit" name="logout"
			       id="logout" value="Logout" />
        </fieldset>
    </form>

    <?php
    oci_free_statement($title_query);
    oci_close($conn);
}

?>

<?php
function create_session_dropdown()
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

    // $username = strip_tags($_POST["username"]);

    // $password = strip_tags($_POST["password"]);
    
    // $_SESSION["username"] = $username;
    // $_SESSION["password"] = $password;

    //   NOW: can you connect to Oracle with them?
    //     (NOTE that hsu_conn_sess destroys session and
    //     exits the PHP document if it fails...!)

    $conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]);

    // if reach here -- CONNECTED!

    $title_query_str = "select isbn, title_name
                       from title
                       order by title_name";
    $title_query = oci_parse($conn, $title_query_str);
    oci_execute($title_query);

    // build a form with a dropdown

    ?>
    <form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
            <legend> Select Desired ISBN </legend>
            <select name="titles">
            <?php
            while (oci_fetch($title_query))
            {
                $curr_isbn = oci_result($title_query, "ISBN");
                $curr_title_name = oci_result($title_query, "TITLE_NAME");
                ?>
                <option value="<?= $curr_isbn ?>"> 
                    <?= $curr_title_name ?>, <?= $curr_isbn ?> </option>
                <?php
            }
            ?>
            </select>
			<label> Quantity: <input type="text" name="qty"
    			                     required="required" /> </label>
        </fieldset>
        <input type="submit" name="submit"
		       id="submit" value="submit choice" />
		
	
    </form>
	
	<form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
			<input type="submit" name="logout"
			       id="logout" value="Logout" />
        </fieldset>
    </form>
	

    <?php
    oci_free_statement($title_query);
    oci_close($conn);
}

?>

