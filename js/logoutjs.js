// logout.js
$(document).ready(function() {
    // we make the logout event whe we click on it we prevent the function of the button and we send an ajax request instead
    $('#logout').click(function(logevent) {
        //show this confiramtion  message when the button is clicked
        var result = confirm("Are you sure you want to logout?");
        //if confirm do the logout
        if(result){
        logevent.preventDefault();
        $.ajax({
            url: 'logoutpage.php',
            type: 'POST',
            success: function() {
                //ajax request finished take me to logout
                window.location.href = "loginpage.php"; 
            },
        
            
        });
    }

    });

});
