
function editcat(){

    //get the page content
    var pagecont = document.getElementById("htmlcontent");
    //get the catelist from the html
    var catel = document.getElementById("catelist").value;
    //convert the json string stored in catel to an array
    var calist = JSON.parse(catel);
    //remove the form after we click on the button
    var imgconts = document.getElementById("imgcont");
    imgconts.innerHTML = '';

    //create a option for each element in the list all the option are saved in a string option
    //autlist.map have a funtion that take each element from the list and the index of it 
    var nameoption1 = calist.map(function(calen, index) {
    //remove the , between the name and last name and put space instead / join used to concatenate the element in the array instead of a ,
  
    return `
    
    <option value="${calen}">${calen}</option>`;
  });
  
  

  //change html
    pagecont.innerHTML = `
    <form id="editcat" method="POST">
    <h3></h3>
    <select type="text" placeholder="Enter category name" name = "categ"size="1" onfocus="this.size = 7" onchange="this.blur();caajax(this.value)" onblur="this.size = 1; this.blur()" >
    <option disabled selected value="">Select category</option>
    ${nameoption1}

    </select>
    </form>
  
    
    `;
 
     
  }
  function caajax(titlev) {
    // create new form
    var formtitts = new FormData();
    
    // add to the new form the field with name book and value titlev
    formtitts.append('categ', titlev);
  
    // send the ajax request
    $.ajax({
      url: 'editcateg.php',
      type: 'POST',
      data: formtitts,
      processData: false,
      contentType: false,
      success: function(response) {
        
        //first we parse the initial array to a normal array
        var catinfo = JSON.parse(response);

        
        //we get the book info
        var id  = catinfo[0];
        var name = catinfo[1];
    
       
        var imgcont = document.getElementById("imgcont");
        imgcont.innerHTML = `

        <form id = "catinf" enctype="multipart/form-data" method="POST">
        <input type="hidden" placeholder="Enter book title" name = "catid" id = "catid" required value = "${id}">
        <button type = "submit" id = "remove3"><img src="../media/trash.png" alt="Button Image"></button>
        <label>Name</label>
        <input type="text" placeholder="Enter book title" name = "caname" id = "fname" required value = "${name}">
        
        
       
        <button type = "submit" id = "save3">Save</button>
        </form>
        
        
        
        `;
    var upforml2 = document.getElementById("catinf");
      upforml2.addEventListener("submit", function(event){
        var clicked = event.submitter.id;

        if(clicked === "save3"){
          upcatajax(event);
        }
        else if(clicked === "remove3"){
          reajaxcat(event);
        }

      });
    
      },
      
    }
    );
  }
  //ajax for the save
function upcatajax(event) {

  event.preventDefault();
  // create new form with same as the form we have
  var upform3 = new FormData(event.target);


  // send the ajax request
  $.ajax({
    url: 'upcatepage.php',
    type: 'POST',
    data: upform3,
    processData: false,
    contentType: false,
    success: function(response) {
      
      document.getElementById("catinf").reset();
      //we send the temp title to the function
      reffpp2(response);
       
    
    }

  });
}


//reffresh the page
function reffpp2(value) {
  //we save in the storage session a bool that we are realoding
  sessionStorage.setItem("reloadd22", true);
  //we save the temp auther id in the sessionstorage
  sessionStorage.setItem("tmpcatname", value);
  document.location.reload();


}


///ajax for the remove
function reajaxcat(event) {

var result = confirm("Are you sure you want to remove?");
  event.preventDefault();
  // create new form with same as the form we have
  var refform2 = new FormData(event.target);
    if(result){
  // send the ajax request
  $.ajax({
    url: 'recategpage.php',
    type: 'POST',
    data: refform2,
    processData: false,
    contentType: false,
    success: function(response) {
      //we send the temp auther id to the function
      alert(response);
      reff2();
       
    
    },
    error: function(response){
        alert("Failed to delete author");
        
        

    }

  });
}
}

//reffresh the page
function reff2() {
  //we save in the storage session a bool that we are realoding
  sessionStorage.setItem("reloadss2", true);
  document.location.reload();

}

//we get the bool that save in the sessionstorage
var reloadedd2 = sessionStorage.getItem("reloadd22");
//we get the bool that save in the sessionstorage
var reloadaa2 = sessionStorage.getItem("reloadss2");

//check if the edit author button are clicked
if(reloadedd2 || reloadaa2){
//after the load check wich button reload the page
window.onload = function() {
  //we get the temp auther id from the sessionstorage
  var tmpcatname = sessionStorage.getItem("tmpcatname");
  // if we relaod the page and the save button is clicked
  if (reloadedd2) {
      //we remove reload from the session storage
      sessionStorage.removeItem("reloadd22");
      editcat();
      caajax(tmpcatname);
      
  }
  //if we reload the page and the remove button is clicked
  if (reloadaa2) {
    //we remove reload from the session storage
    sessionStorage.removeItem("reloadss2");
    editcat();
    
    
}
}
}
