<?php

class db {

    var $tableName;
    var $tableStructure;
    var $primaryKey;

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function __construct() {
        $this->tableName = get_class($this);
        $this->tableName = strtolower($this->tableName);
        $this->getTableStructure();
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // return a table structure array [fieldname] = primaryKey (boolean)
    function getTableStructure() {
        $link = $this->connect();
        $this->tableStructure = array();
        $campos = pg_query("SELECT column_name AS Field , udt_name AS Type , is_nullable AS null ,ordinal_position AS Key, column_default AS default FROM information_schema.columns WHERE table_name = '" . $this->tableName . "'");
        // $campos = mysql_query("SHOW COLUMNS FROM " . $this->tableName);
        /* while ($linea = pg_fetch_array($campos)){
         *  echo $linea['column_name'];
         * }*die(); */
        if ($campos) {
            //if (mysql_num_rows($campos) > 0) {
            if (pg_num_rows($campos) > 0) {
                //while ($row = mysql_fetch_assoc($campos)) {
                while ($row = pg_fetch_assoc($campos)) {
                    //echo ('entro aqui');die();
                    $campo = $row['field'];
                    //if ($row['Key'] == 'PRI') {
                    if ($row['key'] == 1) {
                        $this->primaryKey = $campo;
                        $this->tableStructure[$campo] = '1';
                        //print_r($this->primaryKey);print_r($this->tableStructure);die();
                    } else {
                        $this->tableStructure[$campo] = '0';
                    }
                }
            }
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
    // return a primary key

    /**
     * @return string
     */
    function getPrimaryKey() {
        //para devolver el siguiente valor de la secuencia
        $sql = ("SELECT nextval('" . $this->tableName . "_" . $this->primaryKey . "_seq')");
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        while ($valor = pg_fetch_array($result)) {
            $valor_id = $valor['nextval'];
        }
        return $valor_id;
    }

    function last_Insert_id() {
        //para devolver el valor actual de la secuencia
        /* if ($this->tableName =='tab_archivobin'){
          $sql = ("SELECT currval('tab_archivo_" . $this->primaryKey . "_seq')");
          echo($sql);die;
          } */
        $sql = ("SELECT currval('" . $this->tableName . "_" . $this->primaryKey . "_seq')");
        //echo($sql);die;
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        while ($valor = pg_fetch_array($result)) {
            $valor_id = $valor['currval'];
        }
        return $valor_id;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // insert in the objetct in the database
    function insert() {
        $object_vars = get_object_vars($this);
        $values = "";
        $campos = "";
        //print_r($object_vars);print"<br/>";print_r($this->tableStructure);die;
        foreach ($this->tableStructure as $field => $value) {
            $campos .= $field . ",";
            if ($this->primaryKey == $field) {
                // set primary key
                //echo ('entro aqui');die;
                $values .= "'" . $this->getPrimaryKey() . "',";
//            } elseif ($object_vars [$field] == 0 ) {
//                //print_r ($object_vars [$field]);die;
//                $values .= "'" . $object_vars [$field] . "',";
            } elseif ($object_vars [$field] == '') {
                //print_r ($object_vars [$field]);die;
                $values .= "NULL,";
            } else {
                //print_r ($object_vars [$field]);die;
                $values .= "'" . $object_vars [$field] . "',";
            }
        }
        $campos = substr($campos, 0, - 1); // remove last ','
        //echo ($values);die;
        $values = substr($values, 0, - 1); // remove last ','
        //echo"<br>".$values;die;
        $sql = "insert into " . $this->tableName . " (" . $campos . ") values (" . $values . ")RETURNING " . $this->primaryKey;

        //echo "<br>".$sql; die("mmm");
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        // set id in the object
        // @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //no hay equivalente OJO OJO
        if (($valor = pg_fetch_array($result))) {
            $id = $valor[$this->primaryKey];
        }
        //echo "<br>".$id; die("");
        /* if ($this->tableName =='tab_archivo'){
          DEFINE ('ID_ARC', $id);
          //echo(id_archivo);die;
          } */
        $this->{$this->primaryKey} = $id;
        $this->disconnect($link);
        return $id;
    }

    
    function insert2() {
        $object_vars = get_object_vars($this);
        $values = "";
        $campos = "";
        //print_r($object_vars);print"<br/>";print_r($this->tableStructure);die;
        foreach ($this->tableStructure as $field => $value) {
            $campos .= $field . ",";
            if ($this->primaryKey == $field) {
                // set primary key
                //echo ('entro aqui');die;
                $values .= "'" . $this->getPrimaryKey() . "',";
            } elseif ($object_vars [$field] == 0 ) {
                //print_r ($object_vars [$field]);die;
                $values .= "'" . $object_vars [$field] . "',";
            } elseif ($object_vars [$field] == '') {
                //print_r ($object_vars [$field]);die;
                $values .= "NULL,";
            } else {
                //print_r ($object_vars [$field]);die;
                $values .= "'" . $object_vars [$field] . "',";
            }
        }
        $campos = substr($campos, 0, - 1); // remove last ','
        //echo ($values);die;
        $values = substr($values, 0, - 1); // remove last ','
        //echo"<br>".$values;die;
        $sql = "insert into " . $this->tableName . " (" . $campos . ") values (" . $values . ")RETURNING " . $this->primaryKey;

        //echo "<br>".$sql; die("mmm");
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        // set id in the object
        // @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //no hay equivalente OJO OJO
        if (($valor = pg_fetch_array($result))) {
            $id = $valor[$this->primaryKey];
        }
        //echo "<br>".$id; die("");
        /* if ($this->tableName =='tab_archivo'){
          DEFINE ('ID_ARC', $id);
          //echo(id_archivo);die;
          } */
        $this->{$this->primaryKey} = $id;
        $this->disconnect($link);
        return $id;
    }
    
    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // insert in the objetct in the database
    function insertManual() {
        $object_vars = get_object_vars($this);
        $values = "";
        $campos = "";
        foreach ($this->tableStructure as $field => $value) {
            $campos .= $field . ",";
            if ($this->primaryKey == $field) {
                // set primary key
                $this->{$this->primaryKey} = $object_vars [$field];
            }
            /* elseif ($object_vars [$field]==''){
              //print_r ($object_vars [$field]);die;
              $values .= "NULL,";
              } */
            $values = $values . "'" . $object_vars [$field] . "',";
        }
        //print_r($values);die;
        $campos = substr($campos, 0, - 1);
        $values = substr($values, 0, - 1); // remove last ','

        $sql = "insert into " . $this->tableName . " (" . $campos . ") values (" . $values . ")RETURNING " . $this->primaryKey;
        //echo $sql;die;
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        // @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        /* if ($this->tableName =='tab_archivobin'){
          $id=ID_ARC;
          //echo($id);die;
          }
          else{ */
        // echo ('aqui');print_r (pg_fetch_array($result));die;
        if (($valor = pg_fetch_array($result))) {
            $id = $valor[$this->primaryKey];
        }
        //}
        $this->{$this->primaryKey} = $id;
        $this->disconnect($link);
        return $id;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // update the objetct in the database
    function update() {
        $object_vars = get_object_vars($this);

        $values = "";
        foreach ($this->tableStructure as $field => $value) {
            // Modified: velasco - ypfb
            //if (!empty($object_vars [$field]) || $object_vars [$field] == 0)
            if (!empty($object_vars [$field]))
                $values = $values . " " . $field . "='" . $object_vars [$field] . "',";
        }
        $values = substr($values, 0, - 1); // remove last ','
        $sql = "update " . $this->tableName . " set " . $values . " where " . $this->primaryKey . "='" . $object_vars [$this->primaryKey] . "'";

        $link = $this->connect();
        //print_r($object_vars);
        //print($sql);die;
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // update the objetct in the database
    function updateArchivo() {
        $object_vars = get_object_vars($this);

        $values = "";
        foreach ($this->tableStructure as $field => $value) {
            # CAMBIO IVR
            if (!empty($object_vars [$field]))
                $values = $values . " " . $field . "='" . $object_vars [$field] . "',";
        }
        $values = substr($values, 0, - 1); // remove last ','
        $sql = "update " . $this->tableName . " set " . $values . " where " . $this->primaryKey . "='" . $object_vars [$this->primaryKey] . "'";

        $link = $this->connect();
        //print_r($object_vars);
        //print($sql);die;
        // @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        // wtf! q hace esto
        //mysql_query("set session wait_timeout=1000");
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function updateMult($field, $value, $id) {
        $sql = "update " . $this->tableName . " set " . $field . "='" . $value . "' where " . $this->primaryKey . "='" . $id . "'";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function updateValue($field, $value, $id) {
        $sql = "update " . $this->tableName . " set " . $field . "='" . $value . "' where " . $this->primaryKey . "='" . $id . "'";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function updateValueTwo($field1, $value1, $field2, $value2, $id) {
        $sql = "update " . $this->tableName . " set " . $field1 . "='" . $value1 . "', " . $field2 . "='" . $value2 . "' where " . $this->primaryKey . "='" . $id . "'";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    function updateValueOne($field, $value, $campo, $campoId) {
        $sql = "update " . $this->tableName . " set " . $field . "='" . $value . "' where " . $campo . "='" . $campoId . "'";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    function updateValueOneWhere($field, $value, $campo, $campoId, $where) {
        $sql = "update " . $this->tableName . " set " . $field . "='" . $value . "' where " . $campo . "='" . $campoId . "' $where ";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }
    
    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // delete the object in the database
    function delete() {
        $object_vars = get_object_vars($this);
        $sql = "delete from " . $this->tableName . " where " . $this->primaryKey . "='" . $object_vars [$this->primaryKey] . "'";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // delete the object in the database
    function deleteAll() {
        $object_vars = get_object_vars($this);
        $sql = "delete from " . $this->tableName . " ";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // delete the object in the database
    function deleteByField($field, $value) {
        $object_vars = get_object_vars($this);
        $sql = "delete from " . $this->tableName . " WHERE $field = '$value'";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // delete the object in the database
    function deleteByTwoField($field1, $value1, $field2, $value2) {
        $object_vars = get_object_vars($this);
        $sql = "delete from " . $this->tableName . " WHERE $field1 = '$value1' AND $field2 = '$value2'";
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        }
        $this->disconnect($link);
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // Contador de registros que cumplen una restriccion
    function count($field, $value1) {
        //$object_vars = get_object_vars ( $this );
        if (!is_null($field) && !is_null($value1)) {
            $sql = "select count(" . $this->primaryKey . ") from " . $this->tableName . " where " . $field . " like '" . $value1 . "'";
        } else {
            $sql = "select count(" . $this->primaryKey . ") from " . $this->tableName . "";
        }
        $num = 0;
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        } else {
            while ($row = pg_fetch_array($result)) {
                $num = $row [0];
            }
            pg_free_result($result);
        }

        $this->disconnect($link);
        return $num;
    }

    function count2($field, $value1, $field1, $value2) {
        //$object_vars = get_object_vars ( $this );
        $sql = "select count(" . $this->primaryKey . ") from " . $this->tableName . " where " . $field . " like '" . $value1 . "' and " . $field1 . " like '" . $value2 . "'";
        $num = 0;
        $link = $this->connect();
        $result = pg_query($link, $sql);
        if (!$result) {
            die(pg_errormessage($link) . ": " . pg_errormessage($link) . "SQL = " . $sql);
        } else {
            while ($row = pg_fetch_array($result)) {
                $num = $row [0];
            }
            pg_free_result($result);
        }

        $this->disconnect($link);
        return $num;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // Contador de registros que cumplen una restriccion
    function countBySQL($sql) {
        //$object_vars = get_object_vars ( $this );
        $link = $this->connect();
        $result = pg_query($link, $sql);
        $num = 0;
        if ($result) {
            while ($row = pg_fetch_array($result)) {
                $num = $row [0];
            }
            pg_free_result($result);
        }

        $this->disconnect($link);
        return $num;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    // set the request(array) to Object
    function setRequest2Object($request) {
        $object_vars = get_object_vars($this);
        foreach ($object_vars as $field => $value) {
            if (isset($request [$field])) {
                $this->$field = addslashes(html_entity_decode($request [$field], ENT_QUOTES));
            }
        }
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectAll() {
        $sql = "select * from " . $this->tableName . " ";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    //$object->{$key} = htmlentities(stripslashes(stripslashes($value)),ENT_QUOTES);
                    $object->{$key} = stripslashes(stripslashes($value));
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectAllOrder($order) {
        $sql = "select * from " . $this->tableName . " ORDER BY $order ASC";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectDifferent($field, $value1, $value2, $value3) {
        $sql = "select * from " . $this->tableName . " where " . $field . " <> '" . $value1 . "' and " . $field . " <> '" . $value2 . "' and " . $field . " <> '" . $value3 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectTwoDifferent($field, $value1, $value2) {
        $sql = "select * from " . $this->tableName . " where " . $field . " <> '" . $value1 . "' and " . $field . " <> '" . $value2 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectOneDifferent($field, $value1) {
        $sql = "select * from " . $this->tableName . " where " . $field . " <> '" . $value1 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbSelectByValue($Field, $value) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " like '" . $value . "' ";
        $link = $this->connect();
        $result = pg_query($sql);
        if ($result) {
            $row = pg_fetch_assoc($result);
            $object = new $this->tableName ();
            if ($row) {
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $object;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMajor($Field, $value) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " > '" . $value . "' ORDER BY " . $Field . " ASC";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMinor($Field, $value) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " < '" . $value . "' ORDER BY " . $Field . " ASC";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMajorEqual($Field, $value) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " >= '" . $value . "' ORDER BY " . $Field . " ASC";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMajorEqualsMinus($Field, $value1, $value2) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " >= '" . $value1 . "' and  " . $Field . " < '" . $value2 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMajorMinusEquals($Field, $value1, $value2) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " > '" . $value1 . "' and  " . $Field . " <= '" . $value2 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectDistinct($Field) {
        $sql = "select distinct " . $Field . " from " . $this->tableName . " ";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectDistinctValue($Field, $field1, $value1, $field2, $value2) {
        $sql = "select distinct " . $Field . " from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and " . $field2 . "='" . $value2 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectById($id) {
        $sql = "select * from " . $this->tableName . " where " . $this->primaryKey . "='" . $id . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        if ($result) {
            $row = pg_fetch_assoc($result);
            $object = new $this->tableName ();
            if ($row) {
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $object;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectByValueField($field, $value) {
        $sql = "select * from " . $this->tableName . " where " . $field . "='" . $value . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $object = null;
        if ($result) {
            $row = pg_fetch_assoc($result);
            if ($row) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $object;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectByField($field, $value) {
        $sql = "select * from " . $this->tableName . " where " . $field . "='" . $value . "'";
        $link = $this->connect();
        //print $sql;
        $result = pg_query($sql);
        //echo ( $sql );
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    //$object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                    //codigo de luis freddy
                    $object->{$key} = htmlentities(stripslashes(stripslashes(utf8_decode($value))), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectBy2Field($field1, $value1, $field2, $value2) {
        $sql = "select * from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and " . $field2 . "='" . $value2 . "'";
        ///print($sql);die();
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectBy3Field($field1, $value1, $field2, $value2, $field3, $value3) {
        $sql = "select * from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and " . $field2 . "='" . $value2 . "' and " . $field3 . "='" . $value3 . "'";
        $link = $this->connect();

        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectByFieldOrder($field, $value, $value1) {
        $sql = "select * from " . $this->tableName . " where " . $field . "='" . $value . "' ORDER BY " . $value1 . "";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectByTwoField($field1, $value1, $field2, $value2) {
        $sql = "select * from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and " . $field2 . "='" . $value2 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectByTwoFieldAndDifferent($field1, $value1, $field2, $value2, $field3, $value3) {
        $sql = "select * from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and " . $field2 . "='" . $value2 . "' and " . $field3 . "<>'" . $value3 . "'";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMax($id, $field1, $value1, $field2, $value2, $field3, $value3) {
        $sql = "select max(" . $id . ") AS maximo from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and " . $field2 . "='" . $value2 . "' and " . $field3 . "= '" . $value3 . "' order BY " . $field3 . "";
        $link = $this->connect();
        $result = pg_query($sql);
        $object = null;
        if ($result) {
            $row = pg_fetch_assoc($result);
            if ($row) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $object;
    }

    # METODO CREADO POR IVER

    function dbSelectMaxId($id) {
        //$sql = "select max(".$id.") AS maximo from ".$this->tableName."";
        $sql = "SELECT NULLIF(MAX(" . $id . ") + 1,1) AS maximo FROM " . $this->tableName . "";
        $link = $this->connect();
        $result = pg_query($sql);
        if ($result) {
            $row = pg_fetch_row($result);
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $row [0];
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectGroup($field1, $value1, $field2, $value2, $field3, $value3, $orden) {
        $sql = "select * from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and " . $field2 . "='" . $value2 . "' and " . $field3 . "='" . $value3 . "' Order by " . $orden . ",Orden";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMajorMenu($Field, $value, $value1) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " > '" . $value . "' and Position='" . $value1 . "' ORDER BY " . $Field . " ASC";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectMinorMenu($Field, $value, $value1) {
        $sql = "select * from " . $this->tableName . " where " . $Field . " < '" . $value . "' and Position='" . $value1 . "'  ORDER BY " . $Field . " ASC";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function setValues($row) {
        foreach ($row as $key => $value) {
            $this->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
        }
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbselectByFieldOrField($field1, $value1, $field2, $value2, $value3) {
        $sql = "select * from " . $this->tableName . " where " . $field1 . "='" . $value1 . "' and  (" . $field2 . "='" . $value2 . "' or " . $field2 . "='" . $value3 . "')";
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbSelectBySQL2($SQL_QUERY) {
        //$sql = "select * from ".$this->tableName."";
        $sql = $SQL_QUERY;
        $link = $this->connect();
        $result = pg_query($sql);
        $object = array();
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                //$object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object[$key] = htmlentities(stripslashes(stripslashes($value)));
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    function dbBySQL($SQL_QUERY) {
        //$sql = "select * from ".$this->tableName."";
        $sql = $SQL_QUERY;
        $link = $this->connect();
        $result = pg_query($sql);
        $this->disconnect($link);
        return true;
    }

    function dbSelectBySQL($SQL_QUERY) {
        //$sql = "select * from ".$this->tableName."";
        $sql = $SQL_QUERY;
        //echo ($sql);die();
        $objects = array();
        $link = $this->connect();
        // MODIFIED CASTELLON
        // QUERY SQL ERROR
        $result = pg_query($link, $sql);

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                //////////////////////////////////
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    //$object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                    //codigo de luis freddy
                    $object->{$key} = htmlentities(stripslashes(stripslashes(utf8_decode($value))), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    function dbSelectBySQLArchive($SQL_QUERY) {
        //$sql = "select * from ".$this->tableName."";
        $sql = $SQL_QUERY;
        $objects = array();
        $link = $this->connect();
        $result = pg_query($sql);
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = $value;
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    function dbSelectBySQLj($SQL_QUERY) {
        //$sql = "select * from ".$this->tableName."";
        $sql = $SQL_QUERY;
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            $row = pg_fetch_assoc($result);
            //while ( $row = mysql_fetch_assoc ( $result ) ) {
            /*
             * $object = new $this->tableName ();
              foreach ( $row as $key => $value ) {
              $object->{$key} = htmlentities ( stripslashes ( stripslashes ( $value ) ) );
              } */
            //	$objects [] = $row;
            //}
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $row;
    }

    function dbSelectBySQLField($SQL_QUERY) {
        //$sql = "select * from ".$this->tableName."";
        $sql = $SQL_QUERY;
        $link = $this->connect();
        $result = pg_query($sql);
        $objects = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $object = new $this->tableName ();
                foreach ($row as $key => $value) {
                    $object->{$key} = htmlentities(stripslashes(stripslashes($value)), ENT_QUOTES);
                }
                $objects [] = $object;
            }
            pg_free_result($result);
        }
        $this->disconnect($link);
        return $objects;
    }

    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    function dbAll() {
        $tabla = array();
        $link = $this->connect();

        $result = pg_query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        //$result = mysql_list_tables(PATH_DBNAME);
        if ($result) {
            while ($row = pg_fetch_row($result)) {
                $tabla [] = $row;
            }
            pg_free_result($result);
        }

        $this->disconnect($link);
        return $tabla;
    }

    /*     * ******************** */

    function connect() {
        // require_once("config.inc");
        $link = pg_pconnect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //$link = mysql_pconnect(PATH_DBHOST, PATH_DDUSER, PATH_DBPASS);
        if ($link) {
            /* if (!pg_dbname(PGDATABASE))
              if (!mysql_select_db(PATH_DBNAME))
              die("ERROR. DataBase not found"); */
            return $link;
        } else
            die("ERROR. Can't connect to the server");
    }

    function disconnect($link) {
        if (!@pg_close($link))
        //if (!@mysql_close($link))
            return 0; // TODO: check persistent conection
        return 1;
    }

    function initialize() {
        $settings = new Settings ();
        $settings->setLanguage(_DEFAULT_LANGUAGE);
        $settings->setResource(_DEFAULT_RESOURCE);
        $settings->setError(_ERROR_NONE);
        $_SESSION ["settings"] = $settings;
    }

    function safePage() {
        $this->startSession();
        if (session_is_registered("userid") && $_SESSION ["userid"] != null) {
            $this->noCache();
            return;
        }
        $this->manageError(_ERROR_SAFE_PAGE);
    }

    function startSession() {
        session_name("virtualCorp");
        session_start();
    }

    function noCache() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Pragma: no-cache"); // HTTP/1.0
    }

    function manageError($errorCode) {
        switch ($errorCode) {
            case _ERROR_NONE :
                return;
                break;
            case _ERROR_SAFE_PAGE :
                die("ERROR. Access safePage");
                break;
        }
        exit();
    }

    function setAction() {
        if (isset($_POST ["action"])) {
            return $_POST ["action"];
        }
        if (isset($_GET ["action"])) {
            return $_GET ["action"];
        }
        die("ERROR. Variable action not defined");
    }

    function getAction() {
        if (isset($_POST ["action"])) {
            return $_POST ["action"];
        }
        if (isset($_GET ["action"])) {
            return $_GET ["action"];
        }
        die("ERROR. Variable action not defined");
    }

    /*     * ******************** */
}

?>