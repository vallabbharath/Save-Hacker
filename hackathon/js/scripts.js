function GoogleGeocode() {
  geocoder = new google.maps.Geocoder();
  this.geocode = function(address, callbackFunction) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var result = {};
          result.latitude = results[0].geometry.location.lat();
          result.longitude = results[0].geometry.location.lng();
          callbackFunction(result);
        } else {
          alert("Geocode was not successful for the following reason: " + status);
          callbackFunction(null);
        }
      });
  };
}
var frmdatatime
var totime
//Process form input
$(function() {
  $('#user-location').on('submit', function(e){
    //Stop the form submission
    e.preventDefault();
    //Get the user input and use it
    var userinput = $('form #address').val();
    frmdatatime = $('form #datetimepicker_mask').val();

   totime=$('form #datetimepicker1').val();

    if (userinput == "")
      {
        alert("The input box is blank.");
        return false;
      }

      if (frmdatatime == "____/__/__ __:__")
      {
        alert("From time and date is blank.");
        return false;
      }
      

       if (totime == "")
      {
        alert("To time is blank.");
        return false;
      }
      var g = new GoogleGeocode();
      var address = userinput;

      g.geocode(address, function(data) {
        if(data != null) {
          olat = data.latitude;
          olng = data.longitude;

         // alert(olat);
         // alert(olng);
         
          //var frmdatatime=document.getElementById("datetimepicker_mask");
           
//alert(frmdatatime);
          accessparking(olat, olng, frmdatatime, totime)
          // $('#result').hide();
          // $('#result').append("<p><strong>"+userinput+" -> </strong> Latitude: " + olat + " , " + "Longitude: " + olng + "</p>")
          // $('#result').slideDown("slow");

        } else {
          //Unable to geocode
          alert('ERROR! Unable to geocode address');
        }
      });

  });
});