<?php
if(isset($_GET['added']))
{
?>
<div class="alert alert-success my-3" role="alert">
  A simple success alert—check it out!
</div>
<?php
}elseif(isset($_GET['delete_id']))
{
    mysqli_query($con, "DELETE FROM elections WHERE id = '".$_GET['delete_id']."'") or die("SQL not working");
    ?>
    <div class="alert alert-success my-3" role="alert">
 Data Deleted.
</div>
    
<?php
}
?>

<div class="row my-4">
    <div class="col-4">
        <h3>ADD new Election</h3>
        <form method="post">
            <div class="form-group my-3">
                <input type="text" class="form-control" name="election_topic" placeholder="Election Topic"required />
            </div>
            <div class="form-group my-3">
                <input type="number" class="form-control" name="number_of_candidate" placeholder="Number Of Candidate"required />
            </div>
            <div class="form-group my-3">
                <input type="text" onfocus="this.type='Date'" class="form-control" name="starting_date" placeholder="Start Date"required />
            </div>
            <div class="form-group my-3">
                <input type="text" onfocus="this.type='Date'" class="form-control" name="end_date" placeholder="Ending Date"required />
            </div>
            <input class="btn" style="color:#01539d; background-color:#eea47f;" type="submit" value="Add Election" name="addelection_btn"/>
        </form>
    </div>
    <div class="col-8">
        <h3>Upcoming Election</h3>
        <table class="table" style="border:2px solid #000;">
            <thead class="text-blue">
                <tr style="border:2px solid #000;">
                 <th scope="col" style="border:2px solid #000;">S.No</th>
                 <th scope="col" style="border:2px solid #000;">Election Name</th>
                 <th scope="col" style="border:2px solid #000;"># Candidates</th>
                 <th scope="col" style="border:2px solid #000;">Starting Date</th>
                 <th scope="col" style="border:2px solid #000;">Ending Date</th>
                 <th scope="col" style="border:2px solid #000;">Status Date</th>
                 <th scope="col">Action Date</th>
               </tr>
             </thead>
             <tbody>
                    <?php
                    $SQL_election_data = "SELECT * FROM elections"; 

                    $SQL_election_data_run = $con->query($SQL_election_data);

                    $isanyelectionadded = mysqli_num_rows($SQL_election_data_run);
                    
                    if($isanyelectionadded > 0)
                    {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($SQL_election_data_run))
                        {
                            $election_id = $row['id'];
                            ?>
                            <tr style="border:2px solid #000;">
                                <td style="border:2px solid #000;"><?= $sno++ ?></td>
                                <td style="border:2px solid #000;"><?= $row['election_topic'] ?></td>
                                <td style="border:2px solid #000;"><?= $row['no_candidate'] ?></td>
                                <td style="border:2px solid #000;"><?= $row['starting_date'] ?></td>
                                <td style="border:2px solid #000;"><?= $row['ending_date'] ?></td>
                                <td style="border:2px solid #000;"><?= $row['status'] ?></td>
                                <td style="border:2px solid #000;">
                                    <!-- <a href="#" class="btn btn-sm btn-warning">Edit</a> -->
                                    <button onclick="deletedata(<?php echo $election_id; ?>)" class="btn btn-sm" style="color:#01539d;background-color:#eea47f;">Delete</button>
                                </td>
                            </tr>
                            
                            <?php
                        }
                    }else{
                       ?>
                       <tr>
                        <td colspan="7"> NO any Election Added Yet.</td>
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

if(isset($_POST['addelection_btn']))
{
    $election_topic = strip_tags($con->real_escape_string($_POST['election_topic']));
    $number_of_candidate = strip_tags($con->real_escape_string($_POST['number_of_candidate']));
    $starting_date = strip_tags($con->real_escape_string($_POST['starting_date']));
    $end_date = strip_tags($con->real_escape_string($_POST['end_date']));
    $inserted_by = $_SESSION['username'];
    $inserted_on = date("y-m-d");

    $date1 = date_create($inserted_on);
    $date2 = date_create($starting_date);
    $diff = date_diff($date1,$date2);
    
    if((int)$diff->format("%R%a") > 0)
    {
       $status =  "InActive";
    }else{
        $status = "Active";
    }

    //inser SQL Query

    $SQL_election = "INSERT INTO elections(election_topic, no_candidate, starting_date, ending_date, `status`, inserted_by, inserted_on) VALUES('$election_topic', '$number_of_candidate', '$starting_date', '$end_date' ,'$status', '$inserted_by', '$inserted_on')";

    $SQL_election_run = $con->query($SQL_election) or die("SQL not working");

?>
    <script>location.assign("index.php?addelection=1&added=1")</script>
<?php


}
