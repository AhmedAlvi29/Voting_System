<?php
require '../../admin/inc/config.php';


if(isset($_POST['e_id']) and isset($_POST['c_id']) and isset($_POST['v_id']))
{
    $vote_date = date("y-m-d");
    $vote_time =date("h:i:s a");


    mysqli_query($con, "INSERT INTO voters(election_id, voters_id, candidate_id, voter_date, vote_timing) VALUES('".$_POST['e_id']."', '".$_POST['v_id']."', '".$_POST['c_id']."', '".$vote_date."', '".$vote_time."')") or die("SQL not working");

    echo ("worked");
}




?>