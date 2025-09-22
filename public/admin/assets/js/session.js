// document.addEventListener('DOMContentLoaded', function () {
//     'use strict';

//     // ______________ Modal
//     var myModal = document.getElementById('myModal');
//     myModal.classList.add('show');

//     setTimeout(function () {
//         myModal.classList.remove('show');
//     }, 20000000);

//     setInterval(function () {
//         var progress = document.getElementById('custom-bar');

//         if (progress.value < progress.max) {
//             progress.value += 10;
//         }
//     }, 1000);
// });

'use strict';
    
var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
myModal.toggle()

// setTimeout(function () {
//     myModal.hide();
// }, 12000);

setInterval(function () {
    var progress = document.getElementById('custom-bar');

    if (progress.value < progress.max) {
        progress.value += 10;
    }
}, 1000);