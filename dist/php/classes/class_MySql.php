<?php
class FunctionsMySQL
{

    public function Insert($values = array(), $tabla, $dbh)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET CHARACTER SET utf8mb4");

        foreach ($values as $field => $v) {
            $ins[] = ':' . $field;
        }

        $ins    = implode(',', $ins);
        $fields = implode(',', array_keys($values));
        $sql    = "INSERT INTO $tabla ($fields) VALUES ($ins)";

        $sth = $dbh->prepare($sql);
        foreach ($values as $f => $v) {
            $sth->bindValue(':' . $f, $v);
        }
        $sth->execute();
        return $this->lastId = $dbh->lastInsertId();
    }

    public function Update($values, $tabla, $dbh)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET CHARACTER SET utf8mb4");
        $dataId = array();
       
        if (isset($values['FieldIdUpdate'])) {
            $idField = $values['FieldIdUpdate'];
            unset($values['FieldIdUpdate']);
        } else {
            $idField = 'id';
        }

        foreach ($values as $field => $v) {
            if ($field != 'id') {
                $ins[] = $field . '= :' . $field;
            } else {
                $dataId['id'] = $v;
            }
        }

        $ID          = $dataId['id'];
        $ins         = implode(',', $ins);
        $fields      = implode(',', array_keys($values));
        $sql         = "UPDATE $tabla SET $ins WHERE $idField ='$ID'";
        $sth         = $dbh->prepare($sql);
        $ArrayValues = array();

        foreach ($values as $f => $v) {

            $ArrayValues[':' . $f] = $v;

        }
        unset($ArrayValues[':id']);
        $sth->execute($ArrayValues);
        return $ID ;
    }  
    
    public function UpdateMeta($values, $tabla, $dbh)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET CHARACTER SET utf8mb4");
        $dataId = array();
       
        if (isset($values['FieldIdUpdate'])) {
            $idField = $values['FieldIdUpdate'];
            unset($values['FieldIdUpdate']);
        } else {
            $idField = 'id';
        }

        foreach ($values as $field => $v) {
            if ($field != 'id') {
                $ins[] = $field . '= :' . $field;
            } else {
                $dataId['id'] = $v;
            }
        }

        $ins         = implode(',', $ins);
        $fields      = implode(',', array_keys($values));
        $sql         = "UPDATE $tabla SET $ins";
        $sth         = $dbh->prepare($sql);
        $ArrayValues = array();

        foreach ($values as $f => $v) {

            $ArrayValues[':' . $f] = $v;

        }
        unset($ArrayValues[':id']);
        $sth->execute($ArrayValues);
        return $ArrayValues ;
    }  

    public function UpdateLimitAsignacion($values, $tabla, $dbh,$limit)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET CHARACTER SET utf8mb4");
        $dataId = array();
       
        if (isset($values['FieldIdUpdate'])) {
            $idField = $values['FieldIdUpdate'];
            unset($values['FieldIdUpdate']);
        } else {
            $idField = 'id_asignacion';
        }

        foreach ($values as $field => $v) {
            if ($field != 'id_asignacion') {
                $ins[] = $field . '= :' . $field;
            } else {
                $dataId['id_asignacion'] = $v;
            }
        }

        $ID          = $dataId['id_asignacion'];
        $ins         = implode(',', $ins);
        $fields      = implode(',', array_keys($values));
        $sql         = "UPDATE $tabla SET $ins WHERE $idField ='$ID' AND estado_Asignacion ='SinAsignar'LIMIT $limit";
        $sth         = $dbh->prepare($sql);
        $ArrayValues = array();

        foreach ($values as $f => $v) {

            $ArrayValues[':' . $f] = $v;

        }
        unset($ArrayValues[':id_asignacion']);
        $sth->execute($ArrayValues);
        return $ID ;
    }

}