(function () {
    "use strict";

    $(".search")
        .find("input")
        .each(function () {
            $(this).on("focus", function () {
                $(".search-result").addClass("show");
            });

            $(this).on("focusout", function () {
                $(".search-result").removeClass("show");
            });
        });
})();
