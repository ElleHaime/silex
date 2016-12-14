$(document).ready(function ($) {
  window.fbAppId = document.getElementById('fbAppId').value;
  window.fbAsyncInit = function() {
    FB.init({
      appId      : window.fbAppId,
      status     : true,
      xfbml      : true 
    });
  };

  // Load the SDK asynchronously
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  
  
  shareFb = function (obj) {
      var image = window.location.host + $(obj).data('image-source');
      var source = window.location.host + $(obj).data('item-source');
      var title = window.location.host + $(obj).data('item-title');
      FB.ui({ picture: image,
          	  method: 'feed',
          	  link: source,
          	  caption: title
      }, function(response){}); 
	}
});