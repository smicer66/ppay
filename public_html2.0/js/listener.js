"use strict";

$( document ).ready(function($) {
    var eventMethod = window.parent.addEventListener ? "addEventListener" : "attachEvent";
    console.log("eventMethod..." + eventMethod);
    var eventer = window.parent[eventMethod];
    console.log("eventer..." + eventer);
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
    console.log("messageEvent..." + messageEvent);
    eventer(messageEvent, function (e) {
           //alert(e.data);
        console.log("data....");
        console.log(e.data);
        var dt = e.data;
        dt = JSON.parse(dt);
        console.log(dt);
        if(dt.auto_return_to_merchant!=undefined && dt.auto_return_to_merchant===true && dt.return_url!=undefined && dt.return_url!=null)
        {
            var ifexist = document.querySelector("#probasepaycheckoutframe");
            if(ifexist!=undefined)
            {
                //ifexist.remove();
            }
            setTimeout(function(){
                console.log(encodeURIComponent(JSON.stringify(dt)));
                window.location.href = dt.return_url + '?resp=' + encodeURIComponent(JSON.stringify(dt));
            }, 10000);
            
            //console.log(encodeURIComponent(JSON.stringify(dt)));
        }
        else
        {
            glob_response_data = dt; 
        }
           // Do whatever you want to do with the data got from IFrame in Parent form.
    }, false);
});
