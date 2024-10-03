
function addbook(){
    //get the page content
    var pagecont = document.getElementById("htmlcontent");
    //get the authorlist from the html
    var authorl = document.getElementById("authlist").value;
    //convert the json string stored in authorl to an array
    var aulist = JSON.parse(authorl);
  
    
    //get the category list from html
    var catel = document.getElementById("catlist").value;
    //convert the json string stored in catlist to an array
    var clist = JSON.parse(catel);
  
  
    //create a option for each element in the list all the option are saved in a string option
    //autlist.map have a funtion that take each element from the list and the index of it 
    var nameoption = aulist.map(function(authorn, index) {
    //remove the , between the name and last name and put space instead / join used to concatenate the element in the array instead of a ,
    var fulln = authorn.join(' ');
    return `<option value="${fulln}">${fulln}</option>`;
  });
  
   //create a option for each element in the list all the option are saved in a string option
    //catlist.map have a funtion that take each element from the list and the index of it 
    var cateoption = clist.map(function(catname, index) {
  
      return `<option value="${catname}">${catname}</option>`;
    });
  
  
  //change html
    pagecont.innerHTML = `
    <h2 id="title">Add book</h2>
    <form id="addbookform" enctype="multipart/form-data" method="POST">
      <label>Title</label>
      <input type="text" placeholder="Enter book title" name = "title" id = "title" required>
      <label>Description</label>
      <textarea style="resize: none;" type="text" placeholder="Enter description" name = "description" id = "desc" required></textarea>
      <label>Author</label><select type="text" placeholder="Enter author name" name = "author" >
      ${nameoption}
    </select></a>
      <label>Category</label><select type="text" placeholder="Enter author name" name = "category">
      ${cateoption}
    </select></a>
      <label>Choose cover photo</label>
      <input type="file" placeholder="Upload book cover" name = "cover" required>
      <label>Choose pdf</label>
      <input type="file" placeholder="Upload book pdf" name = "pdf" required>
      <button type="submit" id="addbookbt">Add</button>
    </form>
  
    
    `;
  var form = document.getElementById("addbookform");
  form.addEventListener("submit", bookformajax);
  
     
  }
  
  // send the form with the ajax
  function bookformajax(event) {
    event.preventDefault();

  
    // Get the form data
    var bookform = new FormData(event.target);
  
    // send the ajax request
    $.ajax({
      url: "addbook.php", 
      type: "POST",
      data: bookform,
      processData: false,
      contentType: false,
      success: function (response) {
        document.getElementById("addbookform").reset();
        alert(response);
            
      },
     
    });
  
  
  }

  
  

  