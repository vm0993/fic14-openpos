(function () {
    "use strict";

    $(".editor").each(function () {
        const el = this;
        BalloonEditor.create(el).catch((error) => {
            console.error(error);
        });
    });
})();
