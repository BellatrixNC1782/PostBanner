(function () {
    "use strict"

    /* basic select2 */
    $('.js-example-basic-single').select2();



    /*  for rtl */
    document.querySelector("#switcher-rtl").addEventListener("click",()=>{
        $('.js-example-basic-single').select2();
        $(".js-example-placeholder-single").select2({
            placeholder: "Select a state",
            allowClear: true,
            dir: "rtl"
        });


        /* basic select2 */
    $('.js-example-basic-single').select2({
        dir: "rtl"
    });

})

})();