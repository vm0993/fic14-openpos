import TomSelect from "tom-select";

(function () {
    "use strict";

    // Tom Select
    $(".tom-select-custom").each(function () {

        //new TomSelect(this, options);
        new TomSelect(this, {
            create: true,
            render:{
                option: function(data) {
                    const div = document.createElement('div');
                    div.className = 'form-control form-control-sm align-items-center';

                    const span = document.createElement('span');
                    span.className = 'flex-grow-1';
                    span.innerText = data.text;
                    div.append(span);

                    return div;
                },
            }
        });

    });
})();
