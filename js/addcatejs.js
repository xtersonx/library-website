// add catego method
function addcat(){
    var pagecont = document.getElementById("htmlcontent");
  
  //change html
    pagecont.innerHTML = `
    <h2 id="title">Add Category</h2>
    <form id="addcatform" method="POST">
      <label>Name</label>
      <input type="text" placeholder="Enter Category name" name = "catname" required>
      <button type="submit" id="addcat>bt">Add</button
    </form>
  
    `;
  
    var form = document.getElementById("addcatform");
    form.addEventListener("submit", catformajax);
  }
  // send the form with the ajax
  function catformajax(event) {
    event.preventDefault();

  
    // Get the form data
    var bookform = new FormData(event.target);
  
    // send the ajax request
    $.ajax({
      url: "addcate.php", 
      type: "POST",
      data: bookform,
      processData: false,
      contentType: false,
      success: function (response) {
        document.getElementById("addcatform").reset();
        alert(response);
            
      },
     
    });
  
  
  }
  
  