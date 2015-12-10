<?php

require_once "config.php";

$arr_in = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


/*
  foreach($arr_in as $key=>$value){
  echo "<br />" . $key. ": " .$value;
  }
 */

//to see check_id function for description.

if (!check_id($arr_in["txn_id"])) {

    $msg = "<br /><br />";

    $msg .= "ID Zahlung: " . $arr_in["payer_id"] . "<br />";
    $msg .= "payment_status: " . $arr_in["payment_status"] . "<br />";

    $msg .= "Zahlungsdatum: " . $arr_in["payment_date"] . "<br />";





    $msg .= "<br />------ Lieferadresse---------<br />";

    $msg .= "Name: " . $arr_in["address_name"] . "<br />";

    $msg .= "Adresse: " . $arr_in["address_street"] . "<br />";

    $msg .= "PLZ: " . $arr_in["address_zip"] . "<br />";

    $msg .= "Land: " . $arr_in["address_country"] . "<br />";

    $msg .= "Email: " . $arr_in["payer_email"] . "<br />";


    for ($i = 1; $i <= $arr_in["num_cart_items"]; $i++) {
        $msg .= "<br />......................................<br />";

        $msg .= "ITEM " . $i;

        $msg .= "<br />......................................<br />";

        $msg .= "Artikelnummer: " . $arr_in["item_number" . $i] . "<br />";
        $msg .= "Menge: " . $arr_in["quantity" . $i] . "<br />";
        $msg .= "Betrag: " . $arr_in["mc_gross_" . $i] . " " . $arr_in["mc_currency"] . "<br />";
    }

    $msg .= "<br />";

    $msg .= "Gesambetrag: " . $arr_in["mc_gross"] . "<br />";

    if (!mail($seller_notification_mail, "Test", $msg, "From: Site Test \nContent-Type: text/html; charset=ISO-8859-1") === FALSE) {
        //echo "ERROR";
        check_id(error_get_last());
    }
}// close if (!check_id($arr_in["txn_id"]))


header("Location: ".$site_link."/index.php");
die();







/*
  The transaction id is unique.
 * For technical problems the server can send two times the data of a transaction.
 * The following function check whether the ID has already been handled.
 * Usually all information are saved on database. Hier I use a file.
 * */

function check_id($id) {
    $fp = fopen("transactionsid.txt", "a+") or die("Unable to open file!");

    $check = false;

    while (!feof($fp)) {
        if (fgets($fp) == $id.PHP_EOL) {
            $check = true;   //the id already exists. 
            break;
        }
    }

    if (!$check) {
        fwrite($fp, $id.PHP_EOL);      //append the new id to file
    }

    fclose($fp);

    return $check;
}
