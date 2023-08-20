
jQuery(document).ready(function() {
    // Activate tooltip
    feather.replace({'stroke-width': 2, 'width':'20px'})
    jQuery('[data-toggle="tooltip"]').tooltip();

    // Select/Deselect checkboxes
    var checkbox = jQuery('table tbody input[type="checkbox"]');
    jQuery("#selectAll").click(function() {
        if (this.checked) {
            checkbox.each(function() {
                this.checked = true;
            });
        } else {
            checkbox.each(function() {
                this.checked = false;
            });
        }
    });
    checkbox.click(function() {
        if (!this.checked) {
            jQuery("#selectAll").prop("checked", false);
        }
    });
});