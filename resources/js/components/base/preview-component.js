(function () {
    "use strict";

    // Show code or preview
    $(".preview-component").each(function () {
        const previewComponent = this;
        $(this)
            .find('input[type="checkbox"]')
            .first()
            .on("click", function () {
                if ($(this).is(":checked")) {
                    $(previewComponent).find(".preview").addClass("hide");
                    $(previewComponent).find(".source").removeClass("hide");
                } else {
                    $(previewComponent).find(".preview").removeClass("hide");
                    $(previewComponent).find(".source").addClass("hide");
                }
            });
    });
})();
