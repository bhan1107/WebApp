$(document).ready(function() {

	var lastForm;

    $("#update").click(function() {
    	$(lastForm).css("display", "none");
    	var currentForm = '#' + $('#tableDropdown').val() + "Form";
    	$(currentForm).css("display", "block");
    	lastForm = currentForm;
    });
});