 
function accessuserpwd()   //webservices hit and validation for uname and pwd
{



       var values;
       var username = document.getElementById("username").value;
       var pwd = document.getElementById("password").value;


       if (username=='')
       {
        alert("Enter Username");
        return false;
       }

       if (pwd=='')
       {
        alert("Enter Password");
        return false;
       }

 var usrtype1=document.getElementById("radio1").checked;
 var usrtype2=document.getElementById("radio2").checked;

 if (usrtype1==true)
 {
var usrtype="user";
 }

  if (usrtype2==true)
 {
var usrtype="owner";
 }


       var userpwd = "username=" + username +"&password=" + pwd+"&usertype=" + usrtype;

      
       console.log(userpwd);

        $.ajax({
          type : "post",
         url : baseurl + "user_login",
          data : userpwd,
          dataType : "json",
          Complete : function(xhr) {
            xhr.getResponseHeader("Accept", "json");
          },
          success : function(res) {
            
          if (res.status == "success") {
              console.log(res);
         
          //window.plugins.nativepagetransitions.flip({
// the defaults for direction, duration, etc are all fine
          //"href" : "dashboard.html"
           // });

        if (usrtype=="user")
        {
              window.location.href = "dashboard.html?id="+res.userid;
        }
        else
        {
            window.location.href = "dashboard1.html?id="+res.userid;
        }
            } if (res.status == "fail") { 

               document.getElementById("errormsg").innerHTML="Invalid username or password";
            }

            if (res.status == "fail2") { 

               document.getElementById("errormsg").innerHTML="Your account not activated.";
            }

            if (res.status == "fail1") {
              alert("fail");
            }
          }
        });

      }

      function error(transaction, err)//error function
      {
        alert("DB error : " + err.message);
        return false;
      }


      function newuser()
      {
  
document.getElementById("userlogin").style.display = "none";

document.getElementById("usersignup").style.display = "block";
document.getElementById("usersignpbutt").style.display = "none";


      }


function existinguser() {
  document.getElementById("userlogin").style.display = "block";

document.getElementById("usersignup").style.display = "none";
document.getElementById("usersignpbutt").style.display = "block";
}


      function validateEmail(email) { var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i; return re.test(email); }
       
function validatePhone(mobile) {
   var re = /^\d{10}$/;
   return re.test(mobile);
}

function signupsubmit()
{

     var values;
       var fname = document.getElementById("fname").value;
       var email = document.getElementById("email").value;
       var mobile = document.getElementById("mobile").value;
       var pwd1 = document.getElementById("spassword").value;


       if (fname=='')
       {
        alert("Enter Your Name");
        return false;
       }



       if (email=='')
       {
        alert("Enter Your Email");
        return false;
       }

       if (email!='')
       {
        var res = validateEmail(email);
        if (res==false)
        {
        alert("Enter valid Email");
        return false;
      }
       }

       if (mobile=='')
       {
        alert("Enter Your mobile no.");
        return false;
       }
       if (mobile!='')
       {
        var res = validatePhone(mobile);
        if (res==false)
        {
        alert("Enter valid mobile");
        return false;
      }
       }

       if (pwd1=='')
       {
        alert("Enter Password");
        return false;
       }

 var usrtype1=document.getElementById("radio1").checked;
 var usrtype2=document.getElementById("radio2").checked;

 if (usrtype1==true)
 {
var usrtype="user";
 }

  if (usrtype2==true)
 {
var usrtype="owner";
 }


       var userpwd = "fname=" + fname +"&email=" + email+"&mobile=" + mobile+"&pwd=" + pwd1+"&usertype=" + usrtype;


       console.log(userpwd);

        $.ajax({
          type : "post",
         url : baseurl + "signup",
          data : userpwd,
          dataType : "json",
          Complete : function(xhr) {
            xhr.getResponseHeader("Accept", "json");
          },
          success : function(res) {
          if (res.status == "success") {
              console.log(res);

         
          //window.plugins.nativepagetransitions.flip({
          //"href" : "dashboard.html"
           // });

        if (usrtype=="user")
        {
            window.plugins.nativepagetransitions.flip({
          "href" : "thanks.html"
            });

              //window.location.href = "thanks.html";
        }
        else
        {
           //window.plugins.nativepagetransitions.flip({
         // "href" : "thanks1.html"
          //  });
            window.location.href = "thanks1.html";
        }
            } else {

               document.getElementById("errormsg").innerHTML="Invalid username or password";
            }

            if (res.status == "fail1") {
              alert("fail");
            }
          }
        });


}
