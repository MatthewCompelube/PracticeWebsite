<?php
/*=====
    function: create_choice: void -> void
    purpose: expects nothing, and returns nothing, BUT does
        expect the $_POST array to contain a key "username"
        with a valid Oracle username, and a key "password"
        with a valid Oracle password;
      
        ...if it cannot find these, or if it cannot make a
        valid connection to Oracle using these, it 
        destroys the session and exits;

        ...otherwise, it tries to output to the resulting
        document a dynamically-created dropdown with the choice
		of calling custom-call, custom-session, or an update to
		a data table

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function create_choice()
{
    // first: IS there at least an attempt at a username/password?

    if ( (! array_key_exists("username", $_POST)) or
         (! array_key_exists("password", $_POST)) or
         ($_POST["username"] == "") or
         ($_POST["password"] == "") or
         (! isset($_POST["username"])) or
         (! isset($_POST["password"])) )
    {
        destroy_and_exit("Must enter a username and password!");
    }

    // if reach here, DO have a username and password; 

    $username = strip_tags($_POST["username"]);

    // ONLY using password to log in, so NOT sanitizing it (gulp?)
    
    $password = strip_tags($_POST["password"]);

    // save these for later (should be OK to do now, I THINK, because if
    //     connection fails, WILL be destroying session, and these,
    //     later)
    
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
            <legend> What Would you Like to Do? </legend>
            <select name="options">
			   <option value="employee-table"> Sale Information </option>
			   <option value="custom-table"> Tea Menu </option>
			   <option value="insert-table"> Add Employee </option>
            </select>
        </fieldset>
        <input type="submit" value="submit choice" />        
    </form>

    <?php
    oci_free_statement($title_query);
    oci_close($conn);
}


function create_repeat_choice()
{
    // first: IS there at least an attempt at a username/password?

    if ( (! array_key_exists("username", $_SESSION)) or
         (! array_key_exists("password", $_SESSION)) or
         ($_SESSION["username"] == "") or
         ($_SESSION["password"] == "") or
         (! isset($_SESSION["username"])) or
         (! isset($_SESSION["password"])) )
    {
        destroy_and_exit("Must enter a username and password!");
    } 

    // $username = strip_tags($_POST["username"]);
    
    // $password = strip_tags($_POST["password"]);
    
    // $_SESSION["username"] = $username;
    // $_SESSION["password"] = $password;

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
            <legend> What Would you Like to Do? </legend>
            <select name="options">
			   <option value="employee-table"> Sale Information </option>
			   <option value="custom-table"> Tea Menu </option>
			   <option value="insert-table"> Add Employee </option>
            </select>
        </fieldset>
        <input type="submit" value="submit choice" />        
    </form>

    <?php
    oci_free_statement($title_query);
    oci_close($conn);
}

?>

   

