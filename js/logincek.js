function checkform() {
    
    //email check
    var email = document.getElementById('emailc');
    email.pattern = "[A-Za-z0-9]{2,}@[A-Za-z0-9]{2,}\\.[A-Za-z]{2,}";
    email.setCustomValidity("");
    if (!email.validity.valid) {
        email.setCustomValidity("Invalid email");
        return false;
    
    }
    if(email.value === ""){
        email.setCustomValidity("Empty field");
        return false;    
    }


    //password check
    var password = document.getElementById('passc');
    password.pattern = ".{8,}";
    password.setCustomValidity("");
    if (!password.validity.valid) {
        password.setCustomValidity("Minimum 8 character");
        return false;
    }
    if(password.value === ""){
        password.setCustomValidity("Empty field");
        return false;    
    }


     return true;

    
   
}
//change icon and hide or show pass
function iconchange() {
    var passwordin = document.getElementById("passc");
    var icon = document.querySelector(".iconeye");
  
    if (passwordin.type === "password") {
      passwordin.type = "text";
      icon.innerHTML = '<img src="../media/eye.png" style="width: 20 ; height:20" >';
    } else {
      passwordin.type = "password";
      icon.innerHTML = '<img src="../media/hiddeneye.png" style="width: 20 ; height:20" text="gide">';
    }
  }


