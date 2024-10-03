
//add author method
function addauthor(){
    var pagecont = document.getElementById("htmlcontent");
  
  //change html
    pagecont.innerHTML = `
    <h2 id="title">Add Author</h2>
    <form id="addauthform" method="POST">
      <label>Name</label>
      <input type="text" placeholder="Enter Author name" name = "auname" required>
      <label>Last name</label>
      <input type="text" placeholder="Enter Author last name" name = "aulast" required>
      <label>Nationality</label>
      <input type="text" placeholder="Enter nationality" name = "nation" required>
      <button type="submit" id="addaubt">Add</button>
    </form>

    `;

  var form = document.getElementById("addauthform");
  form.addEventListener("submit", authformajax);
  }
  // send the form with the ajax
  function authformajax(event) {
    event.preventDefault();

  
    // Get the form data
    var bookform = new FormData(event.target);
  
    // send the ajax request
    $.ajax({
      url: "addauthor.php", 
      type: "POST",
      data: bookform,
      processData: false,
      contentType: false,
      success: function (response) {
        document.getElementById("addauthform").reset();
        alert(response);
      
            
      },
     
    });
  
  
  }