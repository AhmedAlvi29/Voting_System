<?php
require 'inc/header.php';
require 'inc/navigation.php';

if(isset($_GET['homepage']))
{
    require 'inc/homepage.php';
}elseif(isset($_GET['addelection']))
{
    require 'inc/add_election.php';
}elseif(isset($_GET['addcandidate']))
{
    require 'inc/add_candidate.php';
}elseif(isset($_GET['viewresult']))
{
    require 'inc/viewresult.php';
}
?>
<?php
require 'inc/footer.php';
?>