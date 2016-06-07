<?php
$table = array(0,1,2,3,4,5,6,7);
include 'php/getAllTeachers.php';
$teachersArray = getAllTeachers();
?>

<script>
function confirmBox() {
    confirm("Are you sure?");
}
</script>


