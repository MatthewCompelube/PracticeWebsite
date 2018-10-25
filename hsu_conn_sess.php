<?php
    /*-----
        function: hsu_conn_sess: string string -> connection
        purpose: expects an Oracle username and password,
            and has the side-effect of trying to connect to
            HSU's Oracle student database with the given
            username and password;
            returns the resulting connection object if
            successful, 
            BUT if not, it:
            *   complains, including a "try again" link to the
                calling document, 
            *   ends the document,
            *   destroys the current session, and
            *   exits the calling PHP

        uses: 328footer.html
        last modified: 2018-04-15
    -----*/

    function hsu_conn_sess($usr, $pwd)
    {
        // set up db connection string

        $db_conn_str = 
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

        // let's try to log on using this string!

        $connctn = oci_connect($usr, $pwd, $db_conn_str);
  
        // complain and destroy session exit from HERE if fails!

        if (! $connctn)
        {
        ?>
            <p> Could not log into Oracle, sorry. </p>
            <p> <a 
                href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
                Try again </a> 
            </p>
            <?php
            require_once("328footer.html");
            ?>
</body>
</html>
            <?php
            session_destroy();
            exit;        
        }

        return $connctn;
    }
?>
   

