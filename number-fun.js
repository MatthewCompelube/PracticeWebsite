"use strict";

/*-----
    add event handler functions to form and to button
    AFTER the page is loaded

    including: CHECKING if getElementById returns null
        before try to attach attributes to
        nonexistent objects 

    by: Matthew Compelube
    last modified: 2018-04-20
-----*/

window.onload = 
    function()
    {
		var myButton = document.getElementById("do_math");
		myButton.onclick = mathalizer;
    };

/*-----
    signature: allFilled: void -> Boolean
    purpose: expects nothing, returns true if
        the 1st textfield and number field meet
        bizarre criteria,
        OTHERWISE, it returns false
        AND complains in a NEWLY-ADDED errors paragraph
-----*/

function mathalizer()
{
	var value1 = document.getElementById("value1");
	var value2 = document.getElementById("value2");
	var textOutput = document.getElementById("output");
	
	var val1 = parseInt(value1.value);
	var val2 = parseInt(value2.value);
	var textval = val1 * val2;
	
	textOutput.innerHTML = textval;
	
}





