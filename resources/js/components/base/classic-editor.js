(function () {
    "use strict";

    $(".editor").each(function () {
        const el = this;
        ClassicEditor.create(el).catch((error) => {
            console.error(error);
        });
    });
})();
