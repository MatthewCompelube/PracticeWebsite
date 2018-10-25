<?php
/*=====
    function: create_sale_dropdown: void -> void
    purpose: expects nothing, and returns nothing, BUT does
        expect the $_POST array to contain a key "username"
        with a valid Oracle username, and a key "password"
        with a valid Oracle password;
      
        ...if it cannot find these, or if it cannot make a
        valid connection to Oracle using these, it 
        destroys the session and exits;

        ...otherwise, it tries to output to the resulting
        document a dynamically-created dropdown with the current
        employee information for a sale

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function create_sale_dropdown()
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

    $sale_query_str = "select sale_num, cust_num 
                                  from sale
                                  order by sale_num";
    $sale_query = oci_parse($conn, $sale_query_str);
    oci_execute($sale_query);

    // build a form with a dropdown

    ?>
    <form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
            <legend> What sale do you what information about? </legend>
            <select name="sales">
            <?php
            while (oci_fetch($sale_query))
            {
                $curr_sale_num = oci_result($sale_query, "SALE_NUM");
                $curr_cust_num = oci_result($sale_query, "CUST_NUM");
                ?>
                <option value="<?= $curr_sale_num ?>"> 
                    Sale #: <?= $curr_sale_num ?>, Customer #: <?= $curr_cust_num ?> </option>
                <?php
            }
            ?>
            </select>
        </fieldset>
        <input type="submit" value="submit choice" />        
    </form>

    <?php
    oci_free_statement($sale_query);
    oci_close($conn);
}

?>