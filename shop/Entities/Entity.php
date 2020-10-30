<?php
namespace Entities;

class Entity
{
    private $id;
    private $table_name;
    private $db;
    
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->db = new \PDO("mysql:dbname=shop;host=mysql", "root", "secret");
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    public function save()
    {
        $props = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $colData = array_map(function($prop) { 
            return [$prop->name => $prop->getValue($this)]; }, $props
        );
        
        if ($this->id) {
            $updateStr = '';
            foreach ($colData as $item) {
                list($key, $val) = $this->parseItem($item);
                $updateStr .= "$key = $val,";
            }
            $updateStr = substr($updateStr, 0, -1);
            $query = "UPDATE $this->table_name SET $updateStr WHERE id = $this->id";
            $pdb = $this->db->prepare($query);
            $res = $pdb->execute();
        } else {
            $cols = '(';
            $vals = '(';
            foreach ($colData as $item) {
                list($key, $val) = $this->parseItem($item);
                $cols .= "$key,";
                $vals .= "$val,";
            }
            $cols = substr($cols, 0, -1);
            $vals = substr($vals, 0, -1);
            $cols .= ')';
            $vals .= ')';
            $query = "INSERT INTO $this->table_name $cols VALUES $vals";
            $pdb = $this->db->prepare($query);
            $res = $pdb->execute();
        }
        return $res;
    }
    
    private function parseItem($item)
    {
        $key = key($item);
        $val = $item[$key];
        if (gettype($val) === 'string') $val = "'$val'";
        return [$key, $val];
    }
    
    public function find($id)
    {
        $query = "SELECT * FROM $this->table_name WHERE id = $id";
        $pdb = $this->db->prepare($query);
        $pdb->execute();
        $fields = $pdb->fetchAll(\PDO::FETCH_NAMED);
        if (empty($fields)) return null;
        foreach ($fields[0] as $key => $val) {
            $this->$key = $val;
        }
        return $this;
    }
    
    public function getId($fields)
    {
        $where = '';
        for ($i = 0; $i < count($fields); $i += 2) {
            $where .= "$fields[$i] = '" . $fields[$i + 1] . "' AND ";
        }
        $where = substr($where, 0, -5);
        $query = "SELECT id FROM $this->table_name WHERE " . $where;
        $pdb = $this->db->prepare($query);
        $pdb->execute();
        return $pdb->fetchAll();
    }
    
    public function getWithJoin($fields, $joins = [], $whereIn = [])
    {
        $cols = implode(',', $fields);
        $join = '';
        if ($joins) {
            $join = "JOIN $joins[0] ON $joins[1] = $joins[2]";
        }
        $where = '';
        if ($whereIn) {
            $where = " WHERE $whereIn[0] IN (" . implode(',', array_slice($whereIn, 1)) . ")";
        } 
        $query = "SELECT $cols FROM $this->table_name " . $join . $where;
        $pdb = $this->db->prepare($query);
        $pdb->execute();
        return $pdb->fetchAll(\PDO::FETCH_NAMED);
    }
    
    public function get($fields, $where = [])
    {
        $cols = implode(',', $fields);
        $whereStr = '';
        if ($where) {
            $whereStr .= "WHERE $where[0] = $where[1]";
        }
        $query = "SELECT $cols FROM $this->table_name " . $whereStr;
        $pdb = $this->db->prepare($query);
        $pdb->execute();
        return $pdb->fetchAll();
    }
    
}