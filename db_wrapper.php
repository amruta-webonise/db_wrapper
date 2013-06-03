<?php
    class DbWrapper extends PDO{

        private static $select = array();
        private static $from = array();
        private static $where = array();
        private static $orderBy = array();
        private static $limit;
        private static $query;
        private static $instanceCreated = FALSE;
        private static $connection;

        public function __construct()
        {
            echo 'in constructor</br>';
            $host= 'localhost';
            $user= 'root';
            $pass= 'webonise6186';
            try
            {
                parent::__construct("mysql:host=$host;dbname=test", $user, $pass);
                echo 'Connection established with MySQL<br/>';
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        static function getInstance() {

            if(self::$instanceCreated==false){
                if(self::$connection == null){
                    self::$connection = new DbWrapper();
                }
                self::$instanceCreated=true;
                return self::$connection;
            }else{
                return null;
            }
        }

        public function getConnection(){
            return self::$connection;
        }

        static function DisconnectFromDatabase() {
            self::$instanceCreated==false;
        }

        public function select($fields=null){
            foreach ($fields as $field) {
                array_push(self::$select,$field);
            }
//            echo'<pre>';print_r(self::$select); echo '</pre>';

            return $this;
        }

        public function from($tables){
            foreach ($tables as $table) {
                array_push(self::$from,$table);
            }
//            echo'<pre>';print_r(self::$from); echo '</pre>';
            return $this;

        }

        public function where($conditions=null){
            self::$where=array_merge(self::$where,$conditions);
//            echo'<pre>';print_r(self::$where); echo '</pre>';
            return $this;

        }

        public function limit($limit){
            self::$limit = $limit;
            return $this;
        }


        public function orderBy($order) {
            self::$orderBy = array_merge(self::$orderBy,$order);
//            echo'<pre>';print_r(self::$orderBy); echo '</pre>';
            return $this;
        }

        public function getQuery(){
            self::$query = self::getSelect();
            self::$query = self::getFrom();
            if(!empty(self::$where))
                self::$query = self::getWhere();
            if(!empty(self::$limit))
                self::$query = self::getLimit();
            if(!empty(self::$orderBy))
                self::$query = self::getOrderBy();
            return self::$query;
        }

        public function getSelect(){
            $count =0;
            self::$query = 'SELECT ';
            if(self::$select == null){
                self::$query .='*';
            }else{
                foreach (self::$select as $field) {
                    if($count==0){
                        self::$query .= $field;
                        $count++;
                    } else{
                        self::$query .= ', '.$field;
                        $count++;
                    }
                }
            }
//                        echo'get select<pre>';print_r(self::$query); echo '</pre>';
            return self::$query;
        }

        public function getFrom(){
            $count =0;
            self::$query .= ' FROM ';
                foreach (self::$from as $table) {
                    if($count==0){
                        self::$query .= $table;
                        $count++;
                    } else{
                        self::$query .= ', '.$table;
                        $count++;
                    }
            }
//            echo'<pre>';print_r(self::$query); echo '</pre>';
            return self::$query;
        }

        public function getWhere(){
            self::$query .= ' WHERE ';
            $cond =null;
            $count=0;
            foreach (self::$where as $key=>$val) {
                if($count==0){
                    $cond.= "$key '$val'";
                    $count++;
                }else{
                    $cond.= " AND $key '$val'";
                }
            }
            self::$query .= $cond;
            return self::$query;
        }

        public function getLimit(){
            self::$query .= ' LIMIT '.self::$limit;
            return self::$query;
        }

        public function getOrderBy() {
            self::$query .= ' ORDER BY ';
            $cond =null;
            $count=0;
            foreach (self::$orderBy as $key=>$val) {
                if($count==0){
                    $cond.= "$key $val";
                    $count++;
                }else{
                    $cond.= " , $key $val";
                }
            }
            self::$query .= $cond;
            echo'<pre>';print_r(self::$query); echo '</pre>';
            return self::$query;
        }

        public function ExecuteQuery($sql)
        {
            return self::$connection->query($sql);
//            echo '<br/>';
//            echo '<br/>';
//            echo '<br/>';
//            echo 'Array fetching=><br/>';
//            foreach (self::$connection->query($sql) as $row)
//            {
//                echo'<pre>';print_r($row); echo '</pre>';
//                //                print $row['fname'] . '<br />';
//            }
//            echo '<br/>';
//            echo '<br/>';
//            echo '<br/>';
        }

        public function save($table_name,$data,$conditions=null){
            $sql=null;
            $cols=null;
            $vals=null;
            $count =0;
            if($conditions==null){
                $sql.= 'INSERT INTO '.$table_name.'(';
                foreach ($data as $col=>$val) {
                    if($count==0){
                        $cols.= $col;
                        $count++;
                    }else{
                        $cols.= ', '.$col;
                    }
                }
                $sql.= $cols.') values(';
                $count=0;
                foreach ($data as $val) {
                    if($count==0){
                        $vals.= "'$val'";
                        $count++;
                    }else{
                        $vals.= ', '."'$val'";
                    }
                }
                $sql.= $vals.')';
                echo $sql;
                try
                {
                     self::$connection->exec("$sql");

                     echo '<br />All values inserted<br />';
                }catch(PDOException $e)
                {
                    echo $e->getMessage();
                }
            } else{
                $sql .= 'UPDATE '.$table_name.' SET ';
                foreach ($data as $col=>$val) {
                    if($count==0){
                        $cols.= "$col = '$val'";
                        $count++;
                    }else{
                        $cols.= " , $col = '$val'";
                    }
                }
                $sql.= $cols.' WHERE ';
                $cond =null;
                $count=0;
                foreach ($conditions as $key=>$val) {
                    if($count==0){
                        $cond.= "$key '$val'";
                        $count++;
                    }else{
                        $cond.= " AND $key '$val'";
                    }
                }
                $sql.= $cond;
                echo $sql;
                try
                {
                    self::$connection->exec("$sql");
                    echo '<br />All values updated<br />';
                }catch(PDOException $e)
                {
                    echo $e->getMessage();
                }
            }
        }

        public function delete($table_name,$conditions){
            $sql=null;
            $count=0;
            $cond=null;
            $sql .= 'DELETE FROM '.$table_name.' WHERE ';

            foreach ($conditions as $key=>$val) {
                if($count==0){
                    $cond.= "$key '$val'";
                    $count++;
                }else{
                    $cond.= " AND $key '$val'";
                }
            }
            $sql.= $cond;
            echo $sql;
            try
            {
                self::$connection->exec("$sql");
                echo '<br />values deleted<br />';
            }catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function count($table_name,$group_by){
//            $sql=null;
            self::$select .= "SELECT $group_by, COUNT(*) AS CNT FROM $table_name GROUP BY $group_by";
            return $this;
        }
    }

?>