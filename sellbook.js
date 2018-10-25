"use strict";

/*-----
    add event handler functions to form and to button
    AFTER the page is loaded

    including: CHECKING if getElementById returns null
        before try to attach attributes to
        nonexistent objects 
-----*/

window.onload = 
    function()
    {
        // add a form-validation function to the 1st state's
        //     form (if we are in the 1st state!)

        var control = document.getElementById("a_button");

        // getElementById returns null if there is no
        //    element with that id

        control.onclick = allFilled;
    };

/*-----
    signature: allFilled: void -> Boolean
    purpose: expects nothing, returns true if
        the 1st textfield and number field meet
        bizarre criteria,
        OTHERWISE, it returns false
        AND complains in a NEWLY-ADDED errors paragraph
-----*/

function allFilled()
{
	// var bodyObjectArray = document.getElementByTagName("body");
	// var bodyObject = bodyObjectArray[2];
	
	var errorGet = document.getElementById("errornum");
	var errorNumber = parseInt(errorGet);
	var errorReport = document.getElementById("errorP");
	var val = document.getElementById("errorid");
	//var val2 = parseInt(val1);
	// Works: var errorOutput = errorReport.value;

	//var guyiop = parseFloat("<?php echo $qty ?>");
	//Doesnt work: checkValue = "Check Check Check Check";
	//errorReport.innerHTML = "Check check check";
	
	// var i;
	// var val2;
	// for (i = 0; i < val.length; i++)
	// {
		// if val[i] === "-"
		// {
			// val2 += val[i] + val[i + 1];
		// }
	// }
	
	var result = true;
	
	// if (errorReport)
    // {
        // errorReport.innerHTML = "";

        // bodyObject.removeChild(errorReport);
    // }
    // else
    // {
        // errorReport = document.createElement("p");

        // errorReport.id = "errors";
    // }
	
	//errorReport.innerHTML = "fasfdkfjslkjdfla";
	if (val.value == -3)
	{
		errorReport.innerHTML = "😠 Quantity is to large! 😠";
		//errorReport.innerHTML = val.value;
		
		//result = false;
	}
	else if ( val.value == -2)
	{
		errorReport.innerHTML = "😡 Quantity must be larger than 0! 😡";
		
		//result = false;
	}
	else if ( val.value == -1)
	{
		errorReport.innerHTML = "ISBN doesn't exist in database";
		
		//result = false;
	}
	else if ( val.value == -4)
	{
		errorReport.innerHTML = "Dear god, no clue how to fix this";
		
		//result = false;
	}
	else if (val.value == 0)
	{
		errorReport.innerHTML = "Uh no errors here. 😎"
	}
	
	// if (result === false)
	// {
		// var form = document.getElementById("completeForm");
		
		// bodyObject.insertBefore(errorReport, form);
	// }
	
	//return result;


	// var qtynumber = document.getElementById("qtyfieldid");
	// var qty = parseInt(qtynumber.innerHTML);
	// var subtotal = parseFloat("<?php echo $qty ?>");
	// var tax = parseFloat("<?php echo $tax ?>");
	// var totalprice = parseFloat("<?php echo $total_price ?>");
	// var price = parseFloat("<?php echo $the_price ?>");
	
	// subtotal.value = qty.value * price.value;
	// tax.value = qty.value * price.value * 0.085;
	// totalprice.value = qty.value + tax.value;
	
	// <?php
	// $_SESSION["qty"] = qty.value;
	// ?>

    // return result;
}

/*----
    let's have the button do something!
----*/

