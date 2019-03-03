<?php
class DbContext
{
    public function __Initialize($DbConn, $TablePrefix = "")
    {
        $this->dbname = $DbConn->Name;
        try {
            $this->db = new PDO($DbConn->Type.":host=".$DbConn->Server.";dbname=".$DbConn->Name,$DbConn->User, $DbConn->Pwd);
        } catch (PDOException $e) {
            Response::SetStatusCodeResult(500, "Internal Server Error");
            exit;        
            $this->TablePrefix = $TablePrefix;
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            $this->$name = new DbSet(new $name());
            $this->$name->Initialize($this->db, $this->dbname, $this->TablePrefix);
            return $this->$name;
        }
    }

    public function __destruct()
    {
        $this->db = null;
    }
}


class DbSet
{
    public function __construct($ref_object)
    {
        $this->table = get_class($ref_object);
        $this->CName = $this->table;
        $reflect = new ReflectionClass($ref_object);
        $this->props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
    }

    public function Initialize($db, $dbname, $TablePrefix)
    {
        $this->table = $TablePrefix.$this->table;
        $this->db = $db;
        $findkey = $this->db->prepare("SELECT k.column_name as KC FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type='PRIMARY KEY' AND t.table_schema='$dbname' AND t.table_name='$this->table';");
        $findkey->execute();
        $row = $findkey->fetch(PDO::FETCH_ASSOC);
        $this->KeyCol = $row["KC"];

        $this->fields = "";
        $this->values = "";
        $this->updt = "";

        foreach ($this->props as $prop) {
            $this->fields .= $prop->getName().",";
            $this->values .= ":".$prop->getName().",";
            if($prop->getName() != $this->KeyCol)
                $this->updt .= $prop->getName()."= :".$prop->getName().",";
        }
        $this->fields = substr($this->fields, 0, strlen($this->fields) - 1);
        $this->values = substr($this->values, 0, strlen($this->values) - 1);
        $this->updt = substr($this->updt, 0, strlen($this->updt) - 1);
    }

    public function GetRange($start = 0, $length = 5)
    {
        $length += $start;
        return $this->db->query("SELECT * FROM $this->table LIMIT $start, $length");
    }

    public function Table()
    {
        return $this->db->query("SELECT * FROM $this->table");
    }

    public function Add($obj)
    {
        $AddConn = $this->db->prepare("INSERT INTO ".$this->table."($this->fields) values($this->values)");
        foreach ($this->props as $prop) {
            $n = $prop->getName();
            $AddConn->bindParam(':'.$n, $obj->$n);
        }
        $AddConn->execute();
        return $this->db->lastInsertId();
    }

    public function AddOrUpdate($obj)
    {
        $AddOrUpdateConn = $this->db->prepare("INSERT INTO ".$this->table."($this->fields) values($this->values) ON DUPLICATE KEY UPDATE $this->updt");
        foreach ($this->props as $prop) {
            $n = $prop->getName();
            $AddOrUpdateConn->bindParam(':'.$n, $obj->$n);
        }
        return $AddOrUpdateConn->execute();
    }

    public function Find($value, $column = "")
    {
        if($column == "")
        {
            $FindConn = $this->db->prepare("SELECT * FROM ".$this->table." WHERE $this->KeyCol = :column");
            $FindConn->bindParam(':column', $value);
        }
        else{
            $FindConn = $this->db->prepare("SELECT * FROM ".$this->table." WHERE $column = :column");
            $FindConn->bindParam(':column', $value);
        }
        $FindConn->execute();

        $res = $FindConn->fetch(PDO::FETCH_ASSOC);
        if(gettype($res) == "boolean")
            return null;
        $obj = new $this->CName();
        foreach ($res as $k=>$v) {
            $obj->$k = $v;
            //print $prop->getName();
        }
        return $obj;
    }

    public function FindWhere(array $query)
    {
        $q = "";
        foreach($query as $k => $v)
        {
            $q .= "$k=:$k AND ";
        }
        $q = substr($q, 0, strlen($q) - 5);
        $FindConn = $this->db->prepare("SELECT * FROM ".$this->table." WHERE $q");
        foreach($query as $k => $v)
        {
            $FindConn->bindParam(':'.$k, $query[$k]);
        }
        $FindConn->execute();

        $res = $FindConn->fetch(PDO::FETCH_ASSOC);
        if(gettype($res) == "boolean")
            return null;
        $obj = new $this->CName();
        foreach ($res as $k=>$v) {
            $obj->$k = $v;
            //print $prop->getName();
        }
        return $obj;
    }

    public function Update($obj)
    {
        $UpdateConn = $this->db->prepare("UPDATE ".$this->table." SET ".$this->updt." WHERE ".$this->KeyCol."=:".$this->KeyCol);        
        foreach ($this->props as $prop) {
            $n = $prop->getName();
            $UpdateConn->bindParam(':'.$n, $obj->$n);
        }
        return $UpdateConn->execute();
    }

    public function Remove($obj)
    {
        $DeleteConn = $this->db->prepare("DELETE FROM ".$this->table." WHERE ".$this->KeyCol."=:".$this->KeyCol);
        $col = $this->KeyCol;
        $DeleteConn->bindParam(":".$this->KeyCol, $obj->$col);
        return $DeleteConn->execute();
    }

    public function Close()
    {
        $this->db->close();
    }
}


class Context
{
    public static $Controller;
    public static $Method;
    public static $ViewName;
    public static $WorkingDir;
}
?>