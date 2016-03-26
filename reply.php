<?php
/**
 * Created by PhpStorm.
 * User: pixoria
 * Date: 25/3/2016
 * Time: 7:51 PM
 */

include("db_c.php");

require_once "captcha.php"; //Verify with Google reCaptcha







// Server Key
$secret = "YOUR KEY";

// empty response
$response = null;

// check secret key
$reCaptcha = new ReCaptcha($secret);



    // if submitted check response
    if ($_POST["g-recaptcha-response"]) {
        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }

    if ($response != null && $response->success) {

        //Escape all HTML to avoid JS/PHP injection
        $title = htmlspecialchars($_POST['title']);
        $glink = htmlspecialchars($_POST['glink']);
        $detail = htmlspecialchars($_POST['detail']);
        $title = mysqli_real_escape_string($link,$title);
        $glink = mysqli_real_escape_string($link,$glink);
        $detail = mysqli_real_escape_string($link,$detail);

        if ($title == null || $glink == null ){
            die();
        }



        $query_post = "INSERT INTO yellowpage (title,glink,detail) VALUES ('$title','$glink','$detail')";

        if (mysqli_query($link, $query_post)) {

            echo null;

        } else {

            echo mysqli_error($link);

        }


        mysqli_close($link);


    } else {
        return null;
    }


?>