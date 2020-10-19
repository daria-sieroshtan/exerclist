"use strict";

$(document).ready(function() {
    var $wrapper = $('.embedded-form-wrapper');

    $wrapper.on('click', '.remove-embedded-form-item', function(e) {
        e.preventDefault();

        $(this).closest('.embedded-form-item')
            .fadeOut()
            .remove();
    });

    $('.embedded-form-add').click(function(e) {
        e.preventDefault();
        var prototype = $wrapper.data('prototype');
        var index = $wrapper.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        $wrapper.data('index', index + 1);
        $('#add-from-button-row').before(newForm);
        $('#workout_workoutExercises_' + index + '_sequentialNumber').val(1)

    });
});
