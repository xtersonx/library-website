
function editauthor(){

    //get the page content
    var pagecont = document.getElementById("htmlcontent");
    //get the authorlist from the html
    var authorl = document.getElementById("authlist").value;
    //convert the json string stored in authorl to an array
    var aulist = JSON.parse(authorl);
    //remove the form after we click on the button
    var imgconts = document.getElementById("imgcont");
    imgconts.innerHTML = '';

    //create a option for each element in the list all the option are saved in a string option
    //autlist.map have a funtion that take each element from the list and the index of it 
    var nameoption = aulist.map(function(authorn, index) {
    //remove the , between the name and last name and put space instead / join used to concatenate the element in the array instead of a ,
  
    return `<option value="${authorn[2]}">${authorn[0]} ${authorn[1]}</option>`;
  });
  
  

  //change html
    pagecont.innerHTML = `
    <form id="editauth" method="POST">
    <h3></h3>
    <select type="text" placeholder="Enter author name" name = "author"size="1" onfocus="this.size = 7" onchange="this.blur();auajax(this.value)" onblur="this.size = 1; this.blur()" >
    <option disabled selected value="">Select author</option>
    ${nameoption}
    </select>
    </form>
  
    
    `;
 
     
  }
  function auajax(titlev) {
    // create new form
    var formtitt = new FormData();
    
    // add to the new form the field with name book and value titlev
    formtitt.append('author', titlev);
  
    // send the ajax request
    $.ajax({
      url: 'editauthor.php',
      type: 'POST',
      data: formtitt,
      processData: false,
      contentType: false,
      success: function(response) {
        
      
       
        //first we parse the initial array to a normal array
        var authinfo = JSON.parse(response);
       
        
        //we get the book info
        var id  = authinfo[0];
        var name = authinfo[1];
        var lname = authinfo[2];
        var nationa = authinfo[3];
       
        var imgcont = document.getElementById("imgcont");
        imgcont.innerHTML = `

        <form id = "authinf" enctype="multipart/form-data" method="POST">
        <input type="hidden" placeholder="Enter book title" name = "authid" id = "auid" required value = "${id}">
        <button type = "submit" id = "remove2"><img src="../media/trash.png" alt="Button Image"></button>
        <label>First name</label>
        <input type="text" placeholder="Enter book title" name = "fname" id = "fname" required value = "${name}">
        <label>Last name</label>
        <input type="text" placeholder="Enter book title" name = "lname" id = "lname" required value = "${lname}">
        <label>Nationality</label>
        <input type="text" placeholder="Enter book title" name = "nationa" id = "nationa" required value = "${nationa}">
       
        <button type = "submit" id = "save2">Save</button>
        </form>
        
        
        
        `;
    var upform2l = document.getElementById("authinf");
      upform2l.addEventListener("submit", function(event){
        var clicked = event.submitter.id;

        if(clicked === "save2"){
          upauajax(event);
        }
        else if(clicked === "remove2"){
          reajaxx(event);
        }

      });
    
      },
      
    }
    );
  }
  //ajax for the save
function upauajax(event) {

  event.preventDefault();
  // create new form with same as the form we have
  var upform2 = new FormData(event.target);


  // send the ajax request
  $.ajax({
    url: 'upauthorpage.php',
    type: 'POST',
    data: upform2,
    processData: false,
    contentType: false,
    success: function(response) {
      
      document.getElementById("authinf").reset();
      //we send the temp title to the function
      reffpp(response);
       
    
    }

  });
}


//reffresh the page
function reffpp(value) {
  //we save in the storage session a bool that we are realoding
  sessionStorage.setItem("reloadd", true);
  //we save the temp auther id in the sessionstorage
  sessionStorage.setItem("tmpauthid", value);
  document.location.reload();


}


///ajax for the remove
function reajaxx(event) {

var result = confirm("Are you sure you want to remove?");
  event.preventDefault();
  // create new form with same as the form we have
  var refform = new FormData(event.target);
    if(result){
  // send the ajax request
  $.ajax({
    url: 'reauthorpage.php',
    type: 'POST',
    data: refform,
    processData: false,
    contentType: false,
    success: function(response) {
      //we send the temp auther id to the function
      alert(response);
      reff();
       
    
    },
    error: function(response){
        alert("Failed to delete author");
        
        

    }

  });
}
}

//reffresh the page
function reff() {
  //we save in the storage session a bool that we are realoding
  sessionStorage.setItem("reloadss", true);
  document.location.reload();

}

//we get the bool that save in the sessionstorage
var reloadedd = sessionStorage.getItem("reloadd");
//we get the bool that save in the sessionstorage
var reloadaa = sessionStorage.getItem("reloadss");

//check if the edit author button are clicked
if(reloadedd || reloadaa){
//after the load check wich button reload the page
window.onload = function() {
  //we get the temp auther id from the sessionstorage
  var tmpauthid = sessionStorage.getItem("tmpauthid");
  // if we relaod the page and the save button is clicked
  if (reloadedd) {
      //we remove reload from the session storage
      sessionStorage.removeItem("reloadd");
      editauthor();
      auajax(tmpauthid);
      
  }
  //if we reload the page and the remove button is clicked
  if (reloadaa) {
    //we remove reload from the session storage
    sessionStorage.removeItem("reloadss");
    editauthor();
    
    
}
}
}
