
function editbook(){
  //get the page content
  var pagecont = document.getElementById("htmlcontent");
  //get the titlelist from the html
  var titlel = document.getElementById("titlelist").value;
  //convert the json string stored in titlel to an array
  var titlelist = JSON.parse(titlel);

  //remove the form after we click on the button
  var imgconts = document.getElementById("imgcont");
  imgconts.innerHTML = '';

  //create a option for each element in the list all the option are saved in a string option
  //autlist.map have a funtion that take each element from the list and the index of it 
  var titleoption = titlelist.map(function(title, index) {
    
    return `<option value="${title}">${title}</option>`;
  
});


//change html
  pagecont.innerHTML = `
  <form id="editbookf" method="POST">
  <h3></h3>
    <select type="text" id ="tselect"placeholder="Enter book name" name = "book" size="1" onfocus="this.size = 7" onchange="this.blur();titleajax(this.value)" onblur="this.size = 1; this.blur()">
    <option disabled selected value="">Select book</option>
    ${titleoption}
  </select>
  </form>

  
  `;

}

function titleajax(titlev) {
  // create new form
  var formtit = new FormData();

  // add to the new form the field with name book and value titlev
  formtit.append('book', titlev);

  // send the ajax request
  $.ajax({
    url: 'editbook.php',
    type: 'POST',
    data: formtit,
    processData: false,
    contentType: false,
    success: function(response) {
      
      //first we parse the initial array to a normal array
      var allinf = JSON.parse(response);
      //second we get the json of books info saved in the initial array
      var bookinfjs = allinf.bookin;
      //we parse the json to a normal array
      var bookinf = JSON.parse(bookinfjs);
      //we get the json of cat list saved in the inital array
      var catall = allinf.catname;
      //we parse the json into a normal array
      var catinf = JSON.parse(catall);
      //we get the json of the author array
      var auinfjs = allinf.auname;
      //we parse the json to a normal array
      var auinf = JSON.parse(auinfjs);
    


      //we get the book info
      var img  = bookinf[0];
      var title = bookinf[2];
      var desc = bookinf[3];
      var pdf = bookinf[1];
      var auth = bookinf[4];
      var cate = bookinf[5];
      var authl = bookinf[6];
      var bkid = bookinf[7];
      

      //we create a option for each category we have
      var categoryl = catinf.map(function(cname, index) {
        return `<option value="${cname}">${cname}</option>`;
      });

      var authlist = auinf.map(function(auin, index) {
        var name = auin[0];
        var lname = auin[1];
        return `<option value="${name} ${lname}">${name} ${lname}</option>`;
      });


    
      var imgcont = document.getElementById("imgcont");
      imgcont.innerHTML = `
      <form id = "bookinf" enctype="multipart/form-data" method="POST">
      <input type="hidden" id="bookid" value="${bkid}" name = "bookid">
      <label>Cover img</label>
      <img src = "${img}" id = "bimg" value = "${img}" name = "fimg">
      <button type = "submit" id = "remove"><img src="../media/trash.png" alt="Button Image"></button>
      <input type="file" placeholder="Upload book cover" name = "coverb">
      <label>Title</label>
      <input type="text" placeholder="Enter book title" name = "titleb" id = "title" required value = "${title}">
      <label>Description</label>
      <textarea style="resize: none;" type="text" placeholder="Enter book desc" name = "desc" id = "desc" required value = "${desc}">${desc}</textarea>
      <label>Author</label>
      <select type="text" id ="auselect"placeholder="Enter author name" name = "auth" size="1" onfocus="this.size = 7" onchange="this.blur()" onblur="this.size = 1; this.blur()">
      <option value = "${auth} ${authl}">${auth} ${authl}</option>
      ${authlist}
  </select>
  <label>Category</label> 
  <select type="text" id ="catselect"placeholder="Enter category name" name = "categ" size="1" onfocus="this.size = 7" onchange="this.blur()" onblur="this.size = 1; this.blur()">
      <option value = "${cate}">${cate}</option>
      ${categoryl}
  </select>
      <label>Pdf</label>
      <input type="text" placeholder="Enter book title" name = "pdff" id = "pdf" required value = "${pdf}" disabled>
      <a href = "${pdf}" target="_blank" id="readlin">Read book</a>
      <input type="file" placeholder="Upload pdf file" name = "pdffileb" id = "chpdf">
      
      <button type = "submit" id = "save">Save</button>
      </form>
      
      
      
      `;
    
      var upforml = document.getElementById("bookinf");
      upforml.addEventListener("submit", function(event){
        var clicked = event.submitter.id;

        if(clicked === "save"){
          upajax(event);
        }
        else if(clicked === "remove"){
          reajax(event);
        }

      });
      
      

    },
  });
  
}

//ajax for the save
function upajax(event) {
  event.preventDefault();
  // create new form with same as the form we have
  var upform = new FormData(event.target);


  // send the ajax request
  $.ajax({
    url: 'upbookpage.php',
    type: 'POST',
    data: upform,
    processData: false,
    contentType: false,
    success: function(response) {
      document.getElementById("bookinf").reset();
      //we send the temp title to the function
      refp(response);
       
    
    }

  });
}


//refresh the page
function refp(value) {
  //we save in the storage session a bool that we are realoding
  sessionStorage.setItem("reload", true);
  //we save the temp title in the sessionstorage
  sessionStorage.setItem("tmptitle", value);
  document.location.reload();


}




///ajax for the remove
function reajax(event) {
  var result = confirm("Are you sure you want to remove?");
  event.preventDefault();
  // create new form with same as the form we have
  var reform = new FormData(event.target);
  if(result){
  // send the ajax request
  $.ajax({
    url: 'rebookpage.php',
    type: 'POST',
    data: reform,
    processData: false,
    contentType: false,
    success: function(response) {
      //we send the temp title to the function
      alert(response);
      ref();
       
    
    }

  });
}
}

//refresh the page
function ref() {
  //we save in the storage session a bool that we are realoding
  sessionStorage.setItem("reloads", true);
  document.location.reload();

}


  //we get the bool that save in the sessionstorage
  var reloaded = sessionStorage.getItem("reload");
   //we get the bool that save in the sessionstorage
   var reloada = sessionStorage.getItem("reloads");

//check if the button from the edit book are clicked
if(reloaded || reloada){
//after the load check wich button reload the page
window.onload = function() {
  //we get the temp title from the sessionstorage
  var tmptitlez = sessionStorage.getItem("tmptitle");
  // if we relaod the page and the save button is clicked
  if (reloaded) {
      //we remove reload from the session storage
      sessionStorage.removeItem("reload");
      editbook();
      titleajax(tmptitlez);
      
  }
  //if we reload the page and the remove button is clicked
  if (reloada) {
    //we remove reload from the session storage
    sessionStorage.removeItem("reloads");
    editbook();
}
}
}

