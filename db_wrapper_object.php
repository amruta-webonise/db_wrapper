<?php
include 'db_wrapper.php';
$DbWrapper = DbWrapper::getInstance();
//$sql = $DbWrapper->select(array('fname'))->select(array('lname'))->from(array('users'))->getQuery();
$sql = $DbWrapper->from(array('organizations'))->getQuery();
//$sql = $DbWrapper->select()->from(array('organizations'))->where(array('id>' =>'10'))->limit('10')->getQuery();
//$sql = $DbWrapper->select()->from(array('organizations'))->where(array('id>' =>'10','id<='=>'50'))->getQuery();
//$sql = $DbWrapper->select()->from(array('organizations'))->where(array('id>' =>'10'))->where(array('id<='=>'50'))->getQuery();
//$sql = $DbWrapper->select()->from(array('organizations'))->where(array('created_on>' =>'2013-02-10 00:00:00'))->getQuery();
//$sql = $DbWrapper->select()->from(array('organizations'))->where(array('id>=' =>'10','id<='=>'50'))->orderBy(array('name'=>'DESC'))->orderBy(array('id'=>'DESC'))->getQuery();
//$sql = $DbWrapper->select()->from(array('organizations'))->where(array('id=' =>'70'))->getQuery();
//$sql = $DbWrapper->select()->from(array('organizations'))->where(array('name=' =>'Org Name 30'))->getQuery();
//$sql = $DbWrapper->select(array('fname','organisation_id'))->from(array('users'))->where(array('organisation_id=' =>'30'))->getQuery();
//$sql = $DbWrapper->count('users','organisation_id')->getQuery();
echo '<br/>'.$sql;
//$DbWrapper->from('users');//
$result = $DbWrapper->ExecuteQuery($sql);
foreach ($result as $row) {
    echo '<br/>';
    echo'<pre>';print_r($row); echo '</pre>';
    echo '<br/>';
}

//$DbWrapper->save('users',array('fname' =>'trial1','lname'=>'save1'));
//$DbWrapper->save('users',array('fname' =>'abc1','lname'=>'xyz1'),array('id=' => '21'));
//$DbWrapper->delete('users',array('id=' => '1'));

?>