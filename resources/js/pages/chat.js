(function () {
    "use strict";

    $(".chat-list")
        .children()
        .each(function () {
            $(this).on("click", function () {
                $(".chat-box")
                    .children("div:nth-child(2)")
                    .fadeOut(300, function () {
                        $(".chat-box")
                            .children("div:nth-child(1)")
                            .fadeIn(300, function (el) {
                                $(el).removeClass("hidden").removeAttr("style");
                            });
                    });
            });
        });
})();
