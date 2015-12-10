<?php

require_once "config.php";

//The array products is defined in config.php

$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<head>
<meta charset=\"utf-8\">
<title>TEST</title>
<link rel=\"stylesheet\" href=\"css/style.css\" type=\"text/css\" media=\"all\" />
<script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
<script type=\"text/javascript\" src=\"js/page.js\"></script>
</head>
<body>
<div id=\"gallery\">   
";

//view image gallery

foreach ($products as $key => $value) {
    $html .= ""
            . "<div class=\"item\" product-code=\"" . htmlentities($value[3]) . "\">"
            . "<img src=\"images/" . $value[2] . "\" />"
            . "<div class=\"description\">"
            . htmlentities($value[0])
            . ""
            . "</div>"
            . "<div class=\"price\"><span>" . number_format($value[1], 2) . "</span> EUR</div>"
            . "<button type=\"button\" class=\"btn_add_to_cart\">IN DEN WARENKORB</button>"
            . "</div>";
}

//on right side View schopping cart

$html .= " 
</div>
<div id=\"shopping-cart\">

<div id=\"shopping_cart\">
<img src=\"css/icons/cart.jpeg\" width=\"48\" height=\"48\" />
<span id=\"gesamtext\">Gesamtbetrag: <span id=\"gesamvalue\">0.00</span> &euro;</span>
<table id=\"cart-table\">
        
    </table>
    
</div>";



  $html .=" <div class=\"paypal-block\">";
 
//PayPal form
   
$html .="
    
<form method=\"post\" name=\"paypal_form\" action=\"https://".$paypal_link."/cgi-bin/webscr\">
<input type=\"hidden\" name=\"business\" value=\"".$paypal_business_email."\" />
<!-- <input type=\"hidden\" name=\"cmd\" value=\"_xclick\" /> -->

<!-- Transaction information -->

<input type=\"hidden\" name=\"return\" value=\"".$site_link."/response.php\" />
<input type=\"hidden\" name=\"cancel_return\" value=\"".$site_link."/index.php\" />
<input type=\"hidden\" name=\"rm\" value=\"2\" />
<input type=\"hidden\" name=\"currency_code\" value=\"EUR\" />
<input type=\"hidden\" name=\"lc\" value=\"DE\" />
 <input type=\"hidden\" name=\"cs\" value=\"1\" />
 
<input type=\"hidden\" name=\"upload\" value=\"1\">
    <input type=\"hidden\" name=\"cmd\" value=\"_cart\">
   
<input type=\"hidden\" name=\"cbt\" value=\"Weiter\" />


<!-- items information added by js -->

<div id=\"information_items_paypal_form\">


  </div>   
<!-- sale information -->

<input type=\"hidden\" name=\"custom\" value=\"".$paypal_seller_name."\" />
 
 
<!-- pay button -->
<input type=\"image\" id=\"pay-now\" src=\"https://www.paypalobjects.com/de_DE/i/btn/x-click-but6.gif\" border=\"0\" name=\"submit\" alt=\"Hier clicken zum bezahlen\" />
</form>
";



//End PayPal form 




    
    

$html .= "</div>
    </div>
            </body>
        </html>";


echo $html;
