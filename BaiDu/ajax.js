(function(){

    var $ = function(id) {
        return document.getElementById(id);
    };

    $.init = function() {
        try{return new ActiveXObject('Microsoft.XMLHTTP');} catch(e) {}
        try{return new XMLHttpRequest();} catch(e) {}
        alert('您的浏览器版本过低，不支持Ajax技术');
    };

    $.post = function(url,data,callback,type) {
        var xhr = $.init();
        // console.log(xhr);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
            	// alert(1);
                if(type == null) {
                    type = 'text';
                }
                if(type == 'text') {
                    callback(xhr.responseText);
                }
                if(type == 'xml') {
                    callback(xhr.responseXML);
                }
                if(type == 'json') {
                    callback(eval('('+xhr.responseText+')'));
                }
            }
        };
        xhr.open('post',url);

        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.send(data);
    };

    window.$ = $;
})();