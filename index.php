<?php
//INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Going to buy fruits', 'one u are done with the task just delete the note thank u', current_timestamp())
//connecting to the database
$insert=false;

$servername="localhost";
$username="root";
$password="";
$database="notes";

$con=mysqli_connect($servername,$username,$password,$database);
if(!$con){
    die("sorry we failed to connect:". mysqli_connect_errot());
}
if (isset($_GET['delete'])){
  $sno=$_GET['delete'];
 $delete=true;
  $sql ="DELETE FROM `notes` WHERE `sno`=$sno";
  $result=mysqli_query($con,$sql);
}


if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['snoEdit'])){
    
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
    $sql="UPDATE `notes` SET `title` = '$title' , `description`='$description'  WHERE `notes`.`sno` =$sno";
    $result=mysqli_query($con,$sql);
  }
  else{
    $title = $_POST["title"];
    $description = $_POST["description"];
    $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result=mysqli_query($con,$sql);
  }
  


if($result){
  //echo"The record has been inserted successfully";
  $insert=true;
}
else{
  echo "The record was not inserted successfully because of this error -->".mysqli_error($con);
}
 // echo "connection successfull";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <title>Crud Application</title>
  

</head>

<body>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
 Edit Modal
</button>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Record</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/crud/index.php" method="POST">
      <input type="hidden" name="snoEdit" id="snoEdit">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Note Title</label>
        <input type="text" name="titleEdit" class="form-control" id="titleEdit" aria-describedby="emailHelp">
        <div id="title" class="form-text">We'll never share your with anyone else.</div>
      </div>

      <div class="form-floating">
        <textarea class="form-control" name="descriptionEdit" placeholder="Leave a comment here" id="descriptionEdit"></textarea>
        <label for="description">Note description</label>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <button type="submit" class="btn btn-primary">Add note</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg bg-body-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">CRUD Application</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">About</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled">Disabled</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php
  if ($insert){
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
         <strong>Success!</strong> Your records has been inserted successfully.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
       </div>";
        }
  
  ?>
  
  

  <div class="container my-4">
  <h2>Add a note</h2>
    <form action="/crud/index.php" method="POST">
      
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Note Title</label>
        <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">
        <div id="title" class="form-text">We'll never share your with anyone else.</div>
      </div>

      <div class="form-floating">
        <textarea class="form-control" name="description" placeholder="Leave a comment here" id="description"></textarea>
        <label for="description">Note description</label>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <button type="submit" class="btn btn-primary">Add note</button>
    </form>
  </div>
  <div class="container my-4">
   
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $sql="SELECT * FROM `notes`";
      $result=mysqli_query($con,$sql);
      $sno=0;
      while($row=mysqli_fetch_assoc($result)){
        $sno=$sno+1;
        echo"<tr>
        <th scope='row'>".$sno."</th>
        <td>".$row['title'] ."</td>
        <td>".$row['description'] ."</td>
      <td> <button class='edit btn btn-sm- btn-primary' id=" .$row['sno'].">Edit</button> <button class='delete btn btn-sm- btn-primary' id=d" .$row['sno'].">Delete</td>
        </tr>";
}
    
      ?>
        
      </tbody>
    </table>
</tbody>
  </div>
  <hr>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
   
  <script>
    let table = new DataTable('#myTable');
    </script>
 <script>
   edit= document.getElementsByClassName('edit');
   Array.from(edit).forEach((element)=>{
    element.addEventListener("click",(e)=>{
    
      console.log("edit ", );
      tr= e.target.parentNode.parentNode;
      title=tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[1].innerText;
      console.log(title,description);
      titleEdit.value=title;
      descriptionEdit.value=description;
      snoEdit.value=e.target.id;
      console.log(e.target.id);
      $('#editModal').modal('toggle') ;

    })
   })
   deletes= document.getElementsByClassName('delete');
   Array.from(deletes).forEach((element)=>{
    element.addEventListener("click",(e)=>{
    
      console.log("edit ", );
      sno =e.target.id.substr(1,);
      if (confirm("Press a button")){
        console.log("Yes");
        window.location=`/crud/index.php?delete=${sno}`;
      }
      else{
     console.log("No");
      }
     

    })
   })
  </script>
 
</body>

</html>