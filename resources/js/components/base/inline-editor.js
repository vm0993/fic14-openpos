(function () {
    "use strict";

    $(".editor").each(function () {
        const el = this;
        InlineEditor.create(el).catch((error) => {
            console.error(error);
        });
    });
})();
