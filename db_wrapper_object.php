<?php
include 'db_wrapper.php';
$DbWrapper = DbWrapper::getInstance();
//echo '<br/>';
//echo '<br/>';
//echo 'Trial test case';
//$sql1 = $DbWrapper->select(array('fname'))->select(array('lname'))->from(array('users'))->getQuery();
//echo '<br/>'.$sql1;
//$result = $DbWrapper->ExecuteQuery($sql1);
echo '<br/>';
echo '<br/>';
echo 'List all organizations';
$sql2 = $DbWrapper->select(array('name'))->from(array('organizations'))->getQuery();
echo '<br/>'.$sql2;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql2);
echo '<br/>organisation name';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['name']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'List 10 organization whose id is greater than 10';
$sql3 = $DbWrapper->select(array('name'))->from(array('organizations'))->where(array('id>' =>'10'))->limit('10')->getQuery();
echo '<br/>'.$sql3;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql3);
echo '<br/>organisation name';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['name']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'List Organization whose id is greater than 10 and less than equal to 50';
$sql4 = $DbWrapper->select(array('name'))->from(array('organizations'))->where(array('id>' =>'10','id<='=>'50'))->getQuery();
echo '<br/>'.$sql4;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql4);
echo '<br/>organisation name';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['name']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'List Organization whose id is greater than 10 and less than equal to 50--where divided in 2 parts';
$sql5 = $DbWrapper->select(array('name'))->from(array('organizations'))->where(array('id>' =>'10'))->where(array('id<='=>'50'))->getQuery();
echo '<br/>'.$sql5;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql5);
echo '<br/>organisation name';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['name']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'LIst all organization who has bee created after 2013-02-10 00:00:00';
$sql6 = $DbWrapper->select(array('name'))->from(array('organizations'))->where(array('created_on>' =>'2013-02-10 00:00:00'))->getQuery();
echo '<br/>'.$sql6;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql6);
echo '<br/>organisation name';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['name']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'List all organisations who has id between 10 to 50 and its orders should be descending by name';
$sql7 = $DbWrapper->select(array('name'))->from(array('organizations'))->where(array('id>=' =>'10','id<='=>'50'))->orderBy(array('name'=>'DESC'))->orderBy(array('id'=>'DESC'))->getQuery();
echo '<br/>'.$sql7;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql7);
echo '<br/>organisation name';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['name']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'display informations about organization whose id is 70';
$sql8 = $DbWrapper->select()->from(array('organizations'))->where(array('id=' =>'70'))->getQuery();
echo '<br/>'.$sql8;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql8);
echo ' <br/>id - organisation name - created_on';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['id'].' - '.$row['name'].' - '.$row['created_on']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo '<br/>display informations about organization whose name is "Org Name 30"';
$sql9 = $DbWrapper->select()->from(array('organizations'))->where(array('name=' =>'Org Name 30'))->getQuery();
echo '<br/>'.$sql9;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql9);
echo '<br/> id - organisation name - created_on';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['id'].' - '.$row['name'].' - '.$row['created_on']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'display all the users of organization_id 30';
$sql10 = $DbWrapper->select(array('fname','organisation_id'))->from(array('users'))->where(array('organisation_id=' =>'30'))->getQuery();
echo '<br/>'.$sql10;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql10);
echo '<br/> user name - organisation_id';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['fname']. ' - '.$row['organisation_id']; echo '</pre>';
}
echo '<br/>';
echo '<br/>';
echo 'return a count of users per organization with organization name';
$sql11 = $DbWrapper->select(array('organizations.name'))->count()->from(array('users','organizations'))->join(array('users.organisation_id=' =>'organizations.id'))->groupBy('organisation_id')->getQuery();
echo '<br/>'.$sql11;
echo '<br/>';
$result = $DbWrapper->ExecuteQuery($sql11);
echo '<br/>organisation name -- count';
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';echo $row['name'].' - '. $row['CNT']; echo '</pre>';
    echo '<br/>';
}
echo '<br/>';
$DbWrapper->save('users',array('fname' =>'trial1','lname'=>'save1'));
echo '<br/>';

$DbWrapper->save('users',array('fname' =>'abc1','lname'=>'xyz1'),array('id=' => '21'));
echo '<br/>';

$DbWrapper->delete('users',array('id=' => '1'));

?>