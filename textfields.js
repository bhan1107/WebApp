$(document).ready(function() {

	var lastForm;
	// Only for the first one in the drop down menu
	lastForm = $("#conferenceForm");

    $("#tableDropdown").change(function () {
    	$(lastForm).css("display", "none");
    	var currentForm = '#' + $('#tableDropdown').val() + "Form";
    	$(currentForm).css("display", "block");
    	lastForm = currentForm;
    });

     
    lastForm.css("display", "block");
});