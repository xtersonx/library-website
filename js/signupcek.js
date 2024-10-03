function checkform() {
    //name check
    var name = document.getElementById('namec');
    name.pattern = "[A-Za-z]+";
    name.setCustomValidity("");
    if (!name.validity.valid) {
        name.setCustomValidity("Only letters");
        return false;
        
      
    }
    if(name.value === ""){
        name.setCustomValidity("Empty field");
        return false;
      
    }

    //last name check
    var lastname = document.getElementById('lastc');
    lastname.pattern = "[A-Za-z]+";
    lastname.setCustomValidity("");
    if (!lastname.validity.valid) {
        lastname.setCustomValidity("Only letters");
        return false;
        
    }
    if(lastname.value === ""){
        name.setCustomValidity("Empty field");
        return false;    
    }


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
     // Checkbox check
     var checkbox = document.getElementById('cek1');
     if (checkbox.checked) {
        checkbox.setCustomValidity("");
      } else {
        checkbox.setCustomValidity("Required");
      }

     return true;

    
   
}

//clear email error method
function clearemailerr() {
    var emailerr = document.getElementById("emailerr");
        emailerr.textContent = "";
    
}
//start timer to show in the a elemnt
function starttime() {
    var countdown = document.getElementById("countdown");
    var count = 5;

    setInterval(function() {
    countdown.textContent = "Redirect to login page in: " + count + " seconds";
    count--;

    }, 1000);
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