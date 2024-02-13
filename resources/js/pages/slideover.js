(function () {
    "use strict";

    // Show slide over
    $("#programmatically-show-slideover").on("click", function () {
        const el = document.querySelector("#programmatically-slideover");
        const slideOver = tailwind.Modal.getOrCreateInstance(el);
        slideOver.show();
    });

    // Hide slide over
    $("#programmatically-hide-slideover").on("click", function () {
        const el = document.querySelector("#programmatically-slideover");
        const slideOver = tailwind.Modal.getOrCreateInstance(el);
        slideOver.hide();
    });

    // Toggle slide over
    $("#programmatically-toggle-slideover").on("click", function () {
        const el = document.querySelector("#programmatically-slideover");
        const slideOver = tailwind.Modal.getOrCreateInstance(el);
        slideOver.toggle();
    });
})();
