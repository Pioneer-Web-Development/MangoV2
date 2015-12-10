/**
 * Created by jhansen on 9/21/2015.
 */
/*
* This function will handle the majority of ajax calls.
* It takes an end-point, the data to be passed to the endpoint, and will accept a callback function.
* It will return a response object with a true/false status and can call a showMessage function to display a message to the
 */
function ajaxCall(url,data,failCallback,successCallback)
{
    var response={};
    $.ajax({
        url: url,
        type: "GET",
        data: data,
        dataType: 'json',
        error: function()
        {
            response.status=false;
        },
        success: function(data) {
            response.status=data.success;
            response.payload=data;
            if(data.showMessage)
            {
                showMessage(data.message);
            }
        }
    });

    if (failCallback != null && typeof failCallback == 'function' && response.status==false) { failCallback(); }
    if (successCallback != null && typeof successCallback == 'function' && response.status==true) { successCallback(); }
    return response;
}

function showMessage(message)
{
    if(message.type == null || message.type=='')
    {
        message.type='smallBox';
    }
    if(message.type=='smallBox') {
        $.smallBox({
            title: message.title,
            content: message.content,
            color: message.color,
            timeout: message.timeout,
            icon: message.icon
        });
    } else {
        alert(message);
        console.log(message);
    }
}