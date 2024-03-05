<?php
$election_id = $_GET['viewresult'];
?>



<div class="row my-3">
    <div class="col-12">
        <h3>Election Result</h3>
    <?php
    $fetchingactiveelection = mysqli_query($con, "SELECT * FROM elections WHERE id= '$election_id'");

    $totalactiveelection = mysqli_num_rows($fetchingactiveelection);
    
    if($totalactiveelection > 0)
    {
        while($data  = mysqli_fetch_assoc($fetchingactiveelection))
        {
            $election_id = $data['id'];
            $election_topic = $data['election_topic'];
?>

  <table class="table">
                  <thead>
                  
                    <h5 style="color:#01539d;background-color:#eea47f;padding:10px; border-radius:9px;">ELECTION   Topic: <?php echo strtoupper($election_topic); ?></h5>
                  <tr style="border:2px solid #000;">
                      <th style="border:2px solid #000;">Photo</th>
                      <th style="border:2px solid #000;">Candidate Detail</th>
                      <th style="border:2px solid #000;"># Of Votes</th>
                      <!-- <th>Action</th> -->
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      $fetchingcandidate = mysqli_query($con, "SELECT * FROM candidate_detail WHERE election_id = '$election_id'") or die("sql working");
                      
                      while($candidate_data = mysqli_fetch_assoc($fetchingcandidate))
                      {
                        $candidate_id = $candidate_data['id'];
                        $candidate_img = $candidate_data['candidate_img'];

                        // Fetching candidate Votes

                        $fetchingvotes = mysqli_query($con, "SELECT * FROM voters WHERE candidate_id = '$candidate_id'") or die("SQL not wroking");
                        $totalvotes = mysqli_num_rows($fetchingvotes);
                        ?>
                        <tr style="border:2px solid #000;">
                            <td style="border:2px solid #000;"><img class="candidate_img" src="<?php echo $candidate_img; ?>"></td>
                            <td style="border:2px solid #000;"><?php echo "<b>".$candidate_data['candidate_name']."</b><br>".$candidate_data['candidate_detail']; ?></td>
                            <td style="border:2px solid #000;"><?php echo $totalvotes; ?></td>
                            
                        </tr>
                        
                        
                        <?php
                      }
                      
                      ?>
                  </tbody>
          </table>
<?php
    }
    }else{
        echo "No Any Active Election.";
    }
?>
        <?php
        $fetchingvotingdetail = mysqli_query($con, "SELECT * FROM voters WHERE election_id = '$election_id'");

        $number_of_votes =mysqli_num_rows($fetchingvotingdetail);
        if($number_of_votes > 0)
        {
            $sno = 1;
            ?>
            <hr>
       <h3>Voting Details</h3>
       <table class="table">
        <tr style="border:2px solid #000;">
            <th style="border:2px solid #000;">S.NO</th>
            <th style="border:2px solid #000;">VOTER NAME</th>
            <th style="border:2px solid #000;">CONTACT NO</th>
            <th style="border:2px solid #000;">VOTED TO</th>
            <th style="border:2px solid #000;">DATE</th>
            <th style="border:2px solid #000;">TIME</th>
        </tr>
            
            <?php
            while($data = mysqli_fetch_assoc($fetchingvotingdetail))
            {
                $voters_id = $data['voters_id'];
                $candidate_id = $data['candidate_id'];
                $fetchingusername = mysqli_query($con , "SELECT * FROM su_user WHERE id = '$voters_id'");
                $isdataavailbe = mysqli_num_rows($fetchingusername);
                $userdata = mysqli_fetch_assoc($fetchingusername);
                if($isdataavailbe > 0 )
                {
                    
                    $username = $userdata['username'];
                    $contact_no = $userdata['contact_no'];
                    $username = $userdata['username'];
                }else{
                    $username ="No_Data";
                    $contact_no = $userdata['contact_no'];

                }


                $fetchincandidatename = mysqli_query($con , "SELECT * FROM candidate_detail WHERE id = '$candidate_id'");
                $isdataavailbe = mysqli_num_rows($fetchincandidatename);
                $candidatdata = mysqli_fetch_assoc($fetchincandidatename);
                if($isdataavailbe > 0 )
                {
                    
                    $candidatename = $candidatdata['candidate_name'];
                }else{
                    $candidatename ="No_Data";
                   

                }
                ?>
                <tr style="border:2px solid #000;">
                    <td style="border:2px solid #000;"><?php echo $sno++; ?></td>
                    <td style="border:2px solid #000;"><?php echo $username; ?></td>
                    <td style="border:2px solid #000;"><?php echo $contact_no; ?></td>
                    <td style="border:2px solid #000;"><?php echo $candidatename; ?></td>
                    <td style="border:2px solid #000;"><?php echo $data['voter_date']; ?></td>
                    <td style="border:2px solid #000;"><?php echo $data['vote_timing']; ?></td>
                </tr>
                
                
                <?php
            }
            echo "</table>";
        }else{
            echo "No Any Vote Detail Availeble.";
        }
        
        ?>
    </div>
</div>