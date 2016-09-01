/*
  Page Navigation
*/

function step4Show() {
  $("#step3")
    .addClass("hidden");
  $("#step4")
    .removeClass("hidden");
}

function step3Show() {
  $("#step2")
    .addClass("hidden");
  $("#step3")
    .removeClass("hidden");

  costReport(); //Populates hidden form field with report output so it can be emailed
  sendReport(); //Adds user to database and emails the quote
}

function step2Show() {
  document.getElementById('step1')
    .classList.add("hidden");
  document.getElementById('step2')
    .classList.remove("hidden");
}

function formShow() {
  document.getElementById('basic-modal')
    .classList.add("hidden");
  document.getElementById('basic-modal-content')
    .classList.remove("hidden");
}


/*
  Calculator initialization (this must remain global)
*/

var theTotal = 0;

$('.total').html('<div class="row"><div class="col-xs-6"><p>Total</p></div><div class="col-xs-6"><p>$' + theTotal + '</p></div></div>');


/*
  Check to see if an ID associated with a button has a class of 'hidden' or 'show'
  - If 'hidden', change class to 'show'
  - If 'show', change class to 'hidden'

  Check to see if item is selected or deselected
  - If selected, deselect and remove from equation
  - If deselected, select and add to equation
*/

function showPrice(priceId, elem) {

  if ($(elem).hasClass("selected")) {
    $(elem)
      .removeClass("selected")
      .addClass("deselected");

    theTotal = Number(theTotal) - Number($(elem).val());
    $('.total').html('<div class="row"><div class="col-xs-6"><p>Total</p></div><div class="col-xs-6"><p>$' + theTotal + '</p></div></div>');
  } else if ($(elem).hasClass("deselected")) {
    $(elem)
      .removeClass("deselected")
      .addClass("selected");

    theTotal = Number(theTotal) + Number($(elem).val());
    $('.total').html('<div class="row"><div class="col-xs-6"><p>Total</p></div><div class="col-xs-6"><p>$' + theTotal + '</p></div></div>');
  } else {
    $(elem)
      .addClass("selected");

    theTotal = Number(theTotal) + Number($(elem).val());
    $('.total').html('<div class="row"><div class="col-xs-6"><p>Total</p></div><div class="col-xs-6"><p>$' + theTotal + '</p></div></div>');
  }

  if (priceId.className == "hidden") {
    priceId.className = "show";
  } else if (priceId.className == "show") {
    priceId.className = "hidden";
  }

}


/*
  Outputs all selected devices, features, and costs
*/

function costReport() {
  var costReportItems = document.querySelectorAll("#step2 .show"); // Assign costReportItems to all queries in the DOM with a class of "show" within the ID "step2"
  var i;
  for (i = 0; i < costReportItems.length; i++) {
    reportData = reportData + costReportItems[i].innerHTML + "<br >";
  }
  document.getElementById('reportData').value = reportData;
}

function sendReport() {
    //Captured input fields values
    var full_name = $("input#fullName").val();
    var email_address = $("input#emailAddress").val();
    var report = $("input#reportData").val();

    //Process form submit via AJAX
    var dataString = 'full_name='+ full_name + '&email=' + email_address + '&price_list=' + report;
    //alert (dataString);return false;
    $.ajax({
        type: "POST",
        url: "send_quote.php",
        data: dataString,
        success: "Form submitted",
        error: "Form failed!"
    });
    return false;
}

/*
 Resets all inputs
 */
function reset() {
    location.reload();
}
