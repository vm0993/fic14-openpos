(function () {
    "use strict";

    // Copy original code
    $("body").on("click", ".copy-code", function () {
        const content = $(this).html();
        const self = this;
        $(self).html(content.replace("Copy example code", "Copied!"));
        setTimeout(() => {
            $(self).html(content);
        }, 1500);

        const highlight = $(this).closest(".highlight");
        $(highlight).find("textarea")[0].select();
        $(highlight).find("textarea")[0].setSelectionRange(0, 99999);
        document.execCommand("copy");
    });
})();
