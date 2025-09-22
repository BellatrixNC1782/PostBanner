(function(){
    "use strict";

    var myElement = document.getElementById('ChatList');
    new SimpleBar(myElement, { autoHide: true });
    
    var myElement1 = document.getElementById('ChatBody');
    new SimpleBar(myElement1, { autoHide: true });

})();