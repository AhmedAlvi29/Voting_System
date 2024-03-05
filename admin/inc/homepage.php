<div class="row my-4">
    <div class="col-12">
        <h3>Election:</h3>
        <table class="table " style="border:2px solid #000;">
            <thead class="text-blue" >
                <tr style="border:2px solid #000;">
                 <th scope="col" style="border:2px solid #000;">S.No</th>
                 <th scope="col" style="border:2px solid #000;">Election Name</th>
                 <th scope="col" style="border:2px solid #000;"># Candidates</th>
                 <th scope="col" style="border:2px solid #000;">Starting Date</th>
                 <th scope="col" style="border:2px solid #000;">Ending Date</th>
                 <th scope="col" style="border:2px solid #000;">Status Date</th>
                 <th scope="col" style="border:2px solid #000;">Action Date</th>
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
                            <tr  style="border:2px solid #000;">
                                <td style="border:2px solid #000;"><?php echo $sno++ ?></td>
                                <td style="border:2px solid #000;"><?php echo $row['election_topic'] ?></td>
                                <td style="border:2px solid #000;"><?php echo $row['no_candidate'] ?></td>
                                <td style="border:2px solid #000;"><?php echo $row['starting_date'] ?></td>
                                <td style="border:2px solid #000;"><?php echo $row['ending_date'] ?></td>
                                <td style="border:2px solid #000;"><?php echo $row['status'] ?></td>
                                <td style="border:2px solid #000;">
                                    <a href="index.php?viewresult=<?php echo $election_id; ?>" class="btn btn-sm btn-success">View Result</a>
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
    