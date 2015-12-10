$(document).ready(function () {

    //cartlist will save the elements added to cart.
    //In the form any product code is inserted like attribute of element with class "item" like a string.

    //cartlist become an associative array. The keys become the product-cose.



    var cartlist = {};




    // handling click on buttons add to cart

    $(".btn_add_to_cart").click(function () {
        var item = $(this).closest(".item");
        addItemToCart(item);
        update();
    });


    //handling click on remove icon
    $(document).on("click", ".row-remove", function () {
        var product_code = $(this).closest("tr").find("td:first").html();

        delete cartlist[product_code];

        update();
    });



    function addItemToCart(item) {
        var product_code = $(item).attr("product-code");
        //check whether the product is already in the basket

        var price = parseFloat($(item).find(".price span").html());
        if (cartlist[product_code] !== undefined) { // sum to quantity

            cartlist[product_code]["qty"]++;
            cartlist[product_code]["sum"] = Math.round(100 * (price + cartlist[product_code]["sum"])) / 100;


        } else { //add new item


            cartlist[product_code] = {
                "description": $(item).find(".description").html(),
                "price": price,
                "qty": 1, //quantity
                "sum": price  //Sum
            };


        }

    }


    function update() {
        updateviewcart();  //update basket data view
        updatetotalview();    //update whole total
        //set_paypal_form function update the form for paypal.
        // The button 'pay now' is shows only if the shopping-cart contains something.
        
        if(set_paypal_form()){
            $("#pay-now").css("visibility", "visible");
        }else{
            $("#pay-now").css("visibility", "hidden");
        }
    }


    function updateviewcart() {

        var html_code = "";

        for (key in cartlist) {
            html_code += "<tr><td>" + key + "</td>" +
                    "<td>" + cartlist[key]["description"] + "</td>" +
                    "<td>" + cartlist[key]["price"].toFixed(2) + "</td>" +
                    "<td>" + cartlist[key]["qty"] + "</td>" +
                    "<td>" + cartlist[key]["sum"].toFixed(2) + "</td>" +
                    "<td><img src=\"css/icons/remove.jpeg\" width=\"16\" height=\"16\" class=\"row-remove\" /></td>" +
                    "</tr>"
        }

        $("#cart-table").html(html_code);

        //if table is empty, It must be removed

        if (html_code === "") {
            $("#cart-table").html("");
        } else {
            $("#cart-table").html(
                    "<tr>" +
                    " <th>Artikel</th>" +
                    "<th>Name</th>" +
                    "<th>Preis</th>" +
                    "<th>Menge</th>" +
                    "<th>Summe</th>" +
                    "<th></th>" +
                    "</tr>" +
                    html_code
                    );
        }
    }




    function updatetotalview() {
        var total = 0;

        for (key in cartlist) {
            total += cartlist[key]["sum"];
            total = Math.round(total * 100) / 100;
        }

        $("#gesamvalue").html(total.toFixed(2));
    }


    /*
     * update paypal form
     * @returns {Number}  Number of different items
     **/


    function set_paypal_form() {

        //clear on paypal form only info items
        $("#information_items_paypal_form").html("");

        var count = 1;
        for (key in cartlist) {

            $("#information_items_paypal_form")
                    .append("<input type=\"hidden\" name=\"item_number_" + count + "\" value=\"" + key + "\" />" +
                            "<input type=\"hidden\" name=\"item_name_" + count + "\" value=\"" + cartlist[key]["description"] + "\" />" +
                            "<input type=\"hidden\" name=\"quantity_" + count + "\" value=\"" + cartlist[key]["qty"] + "\" />" +
                            "<input type=\"hidden\" name=\"amount_" + count + "\" value=\"" + cartlist[key]["price"].toFixed(2) + "\" />");

            count++;
        }

        return count - 1;
    }


}); // close $(document).ready...