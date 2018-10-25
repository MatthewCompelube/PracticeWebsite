"use strict";

/*--- 
    It seems to be OK to have this statement, THEN the function
    updateSummary it attaches; is this because the function
    updateSummary is not actually called until later, when the window
    object's onload event actually occurs??
---*/
      
/*===
    This sets the onload attribute of the window object
       (represents the browser display) so that it is
       a function that sets the event handling for the desired
       elements in this window when this window exists.
===*/    

window.onload = function()
                {
                    var input = document.getElementById("discount");
					
            
                    input.onclick = updateSummary;
                };

/*===
    function updateSummary: expects nothing, returns nothing,
        has the side-effects of setting an element with 
        id="topping-summary" (assumed to be a textfield)
        to have a value attribute whose
        value is the names of all checked elements with
        class="toppingChoice" (assumed to be checkboxes)
===*/

function updateSummary()
{
    var price = document.getElementById("price");
	var price_output = document.getElementById("empl_discount");
	
	var math = price.value - (price.value * .3);
	
    //var summaryPara = document.getElementById("topping-summary");
    price_output.innerHTML = "$" + math;
}

