<?php
if(isset($_GET['added']))
{
?>
<div class="alert alert-success my-3" role="alert">
  A simple success alert—check it out!
</div>
<?php
}elseif(isset($_GET['largefile']))
{
    ?>
    <div class="alert alert-success my-3" role="alert">
 Image File Size Is Above 2MB.
</div>
<?php
}elseif(isset($_GET['invalidfile']))
{
    ?>
    <div class="alert alert-success my-3" role="alert">
 Type Of Image Is Invalid.
</div>
<?php
}elseif(isset($_GET['failed']))
{
?>
    <div class="alert alert-success my-3" role="alert">
 Image Uploding Failed.
</div>
<?php
}elseif(isset($_GET['delete_id']))
{
    mysqli_query($con, "DELETE FROM candidate_detail WHERE id = '".$_GET['delete_id']."'") or die("SQL not working");
    ?>
    <div class="alert alert-success my-3" role="alert">
 Data Deleted.
</div>
    
<?php
}
?>

<div class="row my-4">
    <div class="col-4">
        <h3>Candidates Detailes</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group my-3">
               <select class="form-control" name="election_id" required>
                <option value="">Select Election</option>
                <?php
                $SQL_candidate = "SELECT * FROM elections";

                $SQL_candidate_run = $con->query($SQL_candidate);

                $isanyelectionadded = mysqli_num_rows($SQL_candidate_run);

                if($isanyelectionadded > 0)
                {
                    while($candidate_row = mysqli_fetch_assoc($SQL_candidate_run))
                    {
                        $election_id = $candidate_row['id'] ;
                        $election_name = $candidate_row['election_topic'];

                        $allowed_candidate = $candidate_row['no_candidate'];

                        //
                        $fetchincandidate = mysqli_query($con,"SELECT * FROM candidate_detail WHERE election_id = '$election_id'") or die("SQL ERROR");
                        $added_candidate = mysqli_num_rows($fetchincandidate);

                        if($added_candidate < $allowed_candidate)
                        {

                        
                        ?>
                        <option value="<?php echo $election_id;  ?>"><?php echo $election_name;  ?></option>

                        <?php

                        }
                    }
                }else{
                    ?>
                    <option value="">Please Add Election First</option>
                    <?php
                }

                
                ?>
               </select>
            </div>
            <div class="form-group my-3">
                <input type="text" class="form-control" name="candidate_name" placeholder="Candidate Name" required />
            </div>
            <div class="form-group my-3">
                <input type="file" class="form-control" name="candidate_img" required />
            </div>
            <div class="form-group my-3">
                <input type="text" class="form-control" name="candidate_detail" placeholder="Candidate Detail"required />
            </div>
            <input class="btn" style="color:#01539d;background-color:#eea47f;" type="submit" value="Add Candidate" name="addcandidatebtn"/>
        </form>
    </div>
    <div class="col-8">
        <h3>Upcoming Election</h3>
        <table class="table text-color"  style="border:2px solid #000;">
            <thead>
                <tr  style="border:2px solid #000;">
                 <th scope="col"  style="border:2px solid #000;">S.No</th>
                 <th scope="col"  style="border:2px solid #000;">Photo</th>
                 <th scope="col"  style="border:2px solid #000;">Name</th>
                 <th scope="col"  style="border:2px solid #000;">Details</th>
                 <th scope="col"  style="border:2px solid #000;">Election</th>
                 <th scope="col"  style="border:2px solid #000;">Action</th>
               </tr>
             </thead>
             <tbody>
                    <?php
                    $SQL_candidate_data = "SELECT * FROM candidate_detail"; 

                    $SQL_election_data_run = $con->query($SQL_candidate_data);

                    $isanycandidateadded = mysqli_num_rows($SQL_election_data_run);
                    
                    if($isanycandidateadded > 0)
                    {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($SQL_election_data_run))
                        {
                            $election_id = $row['election_id'];
                            $candidate_id = $row['id'];

                            $fetchingelectionname = mysqli_query($con,"SELECT * FROM elections WHERE id = '$election_id'") or die("SQL ERROR"); 
                            $election = mysqli_fetch_assoc($fetchingelectionname);
                            $election_name =$election['election_topic'];

                            $candidate_img = $row['candidate_img'];

                            ?>
                            <tr>
                                <td style="border:2px solid #000;"><?php echo $sno++ ?></td>
                                <td style="border:2px solid #000;"> <img  src='<?php echo $candidate_img; ?>' class="candidate_img"></td>
                                <td style="border:2px solid #000;"><?php echo $row['candidate_name'] ?></td>
                                <td style="border:2px solid #000;"><?php echo $row['candidate_detail'] ?></td>
                                <td style="border:2px solid #000;"><?php echo $election_name ?></td>
                                <td style="border:2px solid #000;">
                                    <!-- <a href="#" class="btn btn-sm btn-warning">Edit</a> -->
                                    <button onclick="deletedata(<?php echo $candidate_id; ?>)" class="btn btn-sm" style="color:#01539d;background-color:#eea47f;">Delete</button>
                                </td>
                            </tr>
                            
                            <?php
                        }
                    }else{
                       ?>
                       <tr>
                        <td colspan="7"> NO any Candidate.</td>
                       </tr>
                       <?php
                    }
                    
                    ?>
             </tbody>
        </table>
    </div>
</div>
    
<script>
    const deletedata = (e_id) =>
    {
        let c = confirm("are you sure");
        if(c == true)
        {
           
          location.assign("index.php?addelection=1&delete_id=" + e_id);
        }
    }
</script>



<?php

if(isset($_POST['addcandidatebtn']))
{
    $election_id = strip_tags($con->real_escape_string($_POST['election_id']));
    $candidate_name = strip_tags($con->real_escape_string($_POST['candidate_name'])); 
    $candidate_detail = strip_tags($con->real_escape_string($_POST['candidate_detail']));
    $inserted_by = $_SESSION['username'];
    $inserted_on = date("y-m-d");



// Image Logic Code
    $targated_folder = "../asset/img/candidators/";
    $candidate_img = $targated_folder.rand(111111111, 9999999999)."_".rand(111111111, 9999999999).$_FILES['candidate_img']['name'];
    $candidate_tmp_name = $_FILES['candidate_img']['tmp_name'];
    
    $candidate_img_type = strtolower(pathinfo($candidate_img, PATHINFO_EXTENSION));

    $allowed_type = array("jpg", "png", "jpeg", "jfif");

    $candidate_img_size = $_FILES['candidate_img']['size'];
    
   if($candidate_img_size < 2000000) // 2mb
   {
        if(in_array($candidate_img_type, $allowed_type))
        {
            if(move_uploaded_file($candidate_tmp_name, $candidate_img))
            {
                $SQL_election = "INSERT INTO candidate_detail(election_id, candidate_name, candidate_detail, candidate_img, insertes_by, inserted_on) VALUES('$election_id', '$candidate_name', '$candidate_detail', '$candidate_img' ,'$inserted_by', '$inserted_on')";

                $SQL_election_run = $con->query($SQL_election) or die("SQL not working");

                echo "<script>location.assign('index.php?addelection=1&added=1')</script>";
            }else{
                echo "<script> location.assign('index.php?addcandidate=1&failed=1'); </script>";
               }

        }else{
    echo "<script> location.assign('index.php?addcandidate=1&invalidfile=1'); </script>";
   }
   }else{
    echo "<script> location.assign('index.php?addcandidate=1&largefile=1'); </script>";
   }
?>
    <!-- <script>location.assign("index.php?addelection=1&added=1")</script> -->
<?php


}

?>