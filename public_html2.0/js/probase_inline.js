"use strict";

let glob_response_data = null;

$( document ).ready(function($) {
    var eventMethod = this.addEventListener ? "addEventListener" : "attachEvent";
    console.log("eventMethod..." + eventMethod);
    var eventer = this[eventMethod];
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



function listen_for_url1(e)
{
    var timer = 0;
    console.log(e);
}


class ProbasePayKiosk{


    constructor(data, callback)
    {
        this.data = data;
        this.init_view(data);
        console.log("callback....");
        console.log(this.data.callback);
        //return callback();
        //this.data.callback();
        //console.log(this.data.callback());
        return (this.b1);
    }

    init_view(data)
    {
        console.log(data);

		if(data['serviceTypeId']!=undefined && data['serviceTypeId']=='1981598182742')
		{
			if(this.validate_data(data)===true)
			{
				var qdata = this.prepare_data_for_query(data);
				console.log(qdata);
				var x = document.createElement("iframe");
				x.setAttribute("style", "position:fixed;top:0;left:0;z-index:1000;border:none;width:100%;height:100%;");//opacity:0;pointer-events:none;
				x.setAttribute("allowTransparency", "true");
				x.setAttribute("width", "100%");
				x.setAttribute("height", "100%");
				x.setAttribute("name", "probasepaycheckout");
				x.src = "http://payments.probasepay.com/?" + qdata;
				x.setAttribute("id", "probasepaycheckoutframe");
				x.setAttribute("name", "probasepaycheckoutframe");
				var ifexist = document.querySelector("#probasepaycheckoutframe");
				if(ifexist!=undefined)
					ifexist.remove();

				document.body.appendChild(x);
				console.log(33330);
			}
		}
		else if(data['serviceTypeId']!=undefined && data['serviceTypeId']=='1981598182746')	
		{
				var qdata = this.prepare_data_for_query(data);
				console.log(qdata);
				var x = document.createElement("iframe");
				x.setAttribute("style", "position:fixed;top:0;left:0;z-index:1000;border:none;width:100%;height:100%;");//opacity:0;pointer-events:none;
				x.setAttribute("allowTransparency", "true");
				x.setAttribute("width", "100%");
				x.setAttribute("height", "100%");
				x.setAttribute("name", "probasepaycheckout");
				x.src = "http://payments.probasepay.com/?" + qdata;
				x.setAttribute("id", "probasepaycheckoutframe");
				x.setAttribute("name", "probasepaycheckoutframe");
				var ifexist = document.querySelector("#probasepaycheckoutframe");
				if(ifexist!=undefined)
					ifexist.remove();

				document.body.appendChild(x);
				console.log(33331);
		}
		else
		{
			if(this.validate_data(data)===true)
			{
				var qdata = this.prepare_data_for_query(data);
				console.log(qdata);
				var x = document.createElement("iframe");
				x.setAttribute("style", "position:fixed;top:0;left:0;z-index:1000;border:none;width:100%;height:100%;");//opacity:0;pointer-events:none;
				x.setAttribute("allowTransparency", "true");
				x.setAttribute("width", "100%");
				x.setAttribute("height", "100%");
				x.setAttribute("name", "probasepaycheckout");
				x.src = "http://payments.probasepay.com/?" + qdata;
				x.setAttribute("id", "probasepaycheckoutframe");
				x.setAttribute("name", "probasepaycheckoutframe");
				var ifexist = document.querySelector("#probasepaycheckoutframe");
				if(ifexist!=undefined)
					ifexist.remove();

				document.body.appendChild(x);
				console.log(33330);
			}
		}
        
    }


    validate_data(data)
    {
        if(data!=undefined && data!=null)
        {
            if(data['paymentItem']!=undefined && data['amount']!=undefined && data['currency']!=undefined && data['merchantId']!=undefined && data['hash']!=undefined && data['deviceCode']!=undefined && data['serviceTypeId']!=undefined && data['orderId']!=undefined)
            {
                if(data['paymentItem']!=null && data['amount']!=null && data['currency']!=null && data['merchantId']!=null && data['hash']!=null && data['deviceCode']!=null && data['serviceTypeId']!=null && data['orderId']!=null)
                {
                    return true;
                }
            }
        }
        console.log(false)
        return false;
    }


    prepare_data_for_query(data)
    {
        var qd = [];
        for(var k in data)
        {
            if(typeof data[k] === "object")
                qd.push(k + "=" + encodeURIComponent(JSON.stringify(data[k])));
            else if(typeof data[k] === "undefined" || typeof data[k] === "function" || typeof data[k] === "symbol")
            {

            }
            else
            {
                qd.push(k + "=" + encodeURIComponent(data[k]));
            }
                
        }
        return qd.join("&");
    }


    b1()
    {
        var timer = 0;
        console.log("Test11");
        timer = setInterval(this.check, 1000);
        return timer;
        
    }


    check()
    {
        console.log(glob_response_data);
        if(glob_response_data!=null)
        {
            return glob_response_data;
        }
        else
        {
            return "xxxx";
        }
    }
    

}


