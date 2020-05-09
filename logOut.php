<?php
// please note that the following code has been referenced from the assignment 3 of the course CSCI 5709 (Advanced topics in web development) source: // https://web.cs.dal.ca/~sappal/csci5709/

/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 17/01/2019
 * Time: 2:06 PM
 */
session_start();// start the session

if( isset($_SESSION['email'])){      // when signed in user tries to sign in, then signed him out first

    // Unsetting session variable. The code below to destroy the session is taken from the source : http://php.net/manual/en/function.session-destroy.php

    $_SESSION = array();// kill session and delete session cookie.

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); // destroying session.
    header('Location: index.php');              // redirect to login.php
}

// Reference ends here; source: http://php.net/manual/en/function.session-destroy.php

?>