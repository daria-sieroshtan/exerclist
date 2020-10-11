"use strict";

$('input[type="file"]').change(function(e){
    var fileName = e.target.files[0].name;
    $(this).parent().find('.custom-file-label').html(fileName);
});