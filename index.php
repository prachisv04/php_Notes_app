<?php
    $insert=false;
    $update = false;
$delete = false;
        // Connect to database 

        $servername = "localhost";
        $username="root";
        $password="";
        $databse ="TODO";

        $conn = mysqli_connect($servername,$username,$password,$databse);
        if(!$conn){
          ?>
<img style="height:98vh;width:98vw" src="images/conn_err.jpg" alt="error">

<?php
          die();
        }
        else{


          if($_SERVER['REQUEST_METHOD']=='POST' AND  isset($_POST['title'])){
            $title = $_POST["title"];
            $description = $_POST["desc"];
            if($title!=""){
              $sql = "INSERT INTO `Notes` (`Title`, `Description`) VALUES ('$title', '$description')";
              $result = mysqli_query($conn, $sql);
            
              if($result){ 
                  $insert = true;
                  $_POST["title"]="";
                  $_POST["desc"]="";
              }
              else{
                  echo "The record was not inserted  because of this error ---> ". mysqli_error($conn);
              } 
              }
          }
        if(isset($_POST['editId']))
          {
            $id = $_POST['editId'];
            $title = $_POST["edittitle"];
            $description = $_POST["editdesc"];
            if($title!=""){
              $sql = "UPDATE `notes` SET `Title`='$title' , `Description` = '$description' WHERE `notes`.`Note_id`='".substr($id,1)."'" ;
             $result = mysqli_query($conn, $sql);
            
              if($result){ 
                  $update = true;
                  $_POST["edittitle"]="";
                  $_POST["editdesc"]="";
              }
              else{
                  echo "The record was not inserted  because of this error ---> ". mysqli_error($conn);
              } 
              }
            }
        
        
        if(isset($_POST['del']))
          {
            $sno = $_POST['delId'];
            
            $sql = "DELETE FROM `Notes` WHERE `Note_id`='$sno'";
                $result = mysqli_query($conn, $sql);
                    
                      if($result){ 
                          $delete = true;
                      }
                      else{
                          echo "The record was not deleted  because of this error ---> ". mysqli_error($conn);
                      } 
          }
        
        }
      
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-do List</title>
  <link rel="shortcut icon" href="images/list-check.svg" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link href="CSS/style.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalTitle">Edit Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/TO_DO/index.php" method="POST">
        <div class="modal-body">
          <div class="card-body">
            
            <div class="mb-3"> 
            <input type="text" hidden class="form-control" id="editId" name="editId">
            </div>

            <div class="mb-3">
              <label for="edittitle" class="form-label">Title</label>
              <input type="text" class="form-control" id="edittitle" name="edittitle">
            </div>
            <div class="mb-3">
              <label for="editdesc" class="form-label">Description</label>
              <textarea class="form-control" id="editdesc" name="editdesc" rows="3"></textarea>
            </div>
          </div>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <div class="logocontainer">
          <img class="logo" src="images/list-check.svg" alt="TODO">
        </div>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item ">
            <a class="nav-link active " aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-light btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Form -->



  <div class="container text-center">
    <div class="row align-items-start ">
      <div class="col my-5 pt-3">
        <div class="card ">
         
          <form action="/TO_DO/index.php" method="POST">
            <div class="form-group mb-2 mt-2">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="note_title">
            </div>
      
            <div class="form-group mb-2 mt-2">
              <label for="desc">Note Description</label>
              <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="form-control btn btn-primary">Add Note</button>
          </form>
        </div>
      </div>
      <div class="col-8 bg-dark text-light pt-5">
       <div class="container">
          <table class="table table-light " id="myTable">
            <thead>
              <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "select * from `Notes`";
              $result = mysqli_query($conn,$sql);
              $no=1;
              while($row=mysqli_fetch_assoc($result)){
                echo"  <tr>
                  <th scope='row'>".$no++."</th>
                  <td>".$row['Title']."</td>
                  <td>".$row['Description']."</td>
                  <td>
                    <button class='edit btn btn-primary btn-circle btn-sm' data-bs-toggle='modal'  data-bs-target='#editModal'><i class='bi bi-pencil' id=e".$row['Note_id']."></i></button>
                  </td>
                  <td>
                  <form method='POST'>
                    <input type='hidden' id='delId' name='delId'>
                    <button  class='delete btn btn-danger btn-circle btn-sm' >
                    <i class='bi bi-x-circle' name='del' id=d".$row['Note_id']."></i>
                    </button>
                   </form>
                  </td>
                </tr>";
              }
              
             ?>
              </tbody>
              </table>
            </div>

            </div>

        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
      <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
      <script>
        $(document).ready(function () {
          $('#myTable').DataTable();

        });
      </script>

      <!-- yaha hum edit ke liye ek listener likhenge and usme se noteid title and desc set karenge -->
      <script>
          //edit selected row
          edits = document.getElementsByClassName("edit");
          Array.from(edits).forEach((element)=>{
            element.addEventListener("click",(e)=>{
              //extract value from tags
              console.log(e.target);
               let row = e.target.parentNode.parentNode.parentNode;
               let title = row.getElementsByTagName("td")[0].innerText;
               let description = row.getElementsByTagName("td")[1].innerText;
              console.log(title,description);
              //set value to modal tags
              edittitle.value = title;
              editdesc.value = description;
              editId.value = e.target.id;
              console.log("id is",e.target.id);
            })//event listener
          });// foreach end

          //delete selected row
          deletes = document.getElementsByClassName("delete");
          Array.from(deletes).forEach((element)=>{
            element.addEventListener("click",(e)=>{

              editId = e.target.id.substr(1);
              delId.value = editId;
              console.log("id is",e.target.id);
            })//event listener
          });// foreach end
      </script>
   
</body>

</html>