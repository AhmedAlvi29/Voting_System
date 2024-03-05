<?php
require 'inc/header.php';
require 'inc/navigation.php'; 


?>
<div class="row my-3">
    <div class="col-12">
        <h3>Voters Penal</h3>
    <?php
    $fetchingactiveelection = mysqli_query($con, "SELECT * FROM elections WHERE `status`= 'Active'");

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
                  <tr>
                      <th colspan="4   "class="bg-black    text-white"><h5>ELECTION   Topic: <?php echo strtoupper($election_topic); ?></h5></th>
                  </tr>
                  <tr>
                      <th>Photo</th>
                      <th>Candidate Detail</th>
                      <th># Of Votes</th>
                      <th>Action</th>
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
                        <tr>
                            <td><img class="candidate_img" src="<?php echo $candidate_img; ?>"></td>
                            <td><?php echo "<b>".$candidate_data['candidate_name']."</b><br>".$candidate_data['candidate_detail']; ?></td>
                            <td><?php echo $totalvotes; ?></td>
                            <td>
                                <?php


                                    $chackifvotecasted = mysqli_query($con, "SELECT * FROM voters WHERE voters_id = '".$_SESSION['user_id']."' and election_id = '".$election_id."'")or die(mysqli_error($con));
                                
                                    $isvotecasted = mysqli_num_rows($chackifvotecasted);
                        
                                   if($isvotecasted > 0)
                                   {
                                    $votecasteddata= mysqli_fetch_assoc($chackifvotecasted);

                                    $votecastedtocandidate =$votecasteddata['candidate_id'] ;

                                    if($votecastedtocandidate == $candidate_id)
                                       {
                                        ?>
                                        <img src="../asset/img/voted.png" width="100px">
                                        
                                        
                                        <?php
                                       }
                                   }else{
                                    ?>
                                    <button class="btn btn-md btn-success" onclick="castvote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)">Vote</button>
                                    <?php
                                   }


                                ?> 
                            </td>
                        </tr>
                        
                        
                        <?php
                      }
                      
                      ?>
                  </tbody>
          </table>
<?php
    }
    }else{
        echo "<h5 class='text-blue'>No Any Active Election.</h5>";
    }
?>
       
    </div>
</div>

<script>
    const castvote = (election_id, costomer_id, voters_id) =>
    {
        $.ajax({
            type: "post",
            url: "inc/ajaxcall.php",
            data : "e_id=" + election_id + "&c_id=" + costomer_id + "&v_id=" +voters_id,
            success :function(response)
            {
                if(response == "worked")
                {
                    location.assign("index.php?votecasted=1");
                }else{
                    location.assign("index.php?votenotcasted=1");
                }
            }
        });
    }
</script>





<?php
require 'inc/footer.php'; 


?>