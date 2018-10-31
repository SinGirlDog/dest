<?php

class elist extend Model {
    public function getList() {
        $sql = 'select * from dede_test';
 
        $this->dsql->SetQuery($sql);
        $this->dsql->Execute();
 
        $rows = array();
        while($row = $this->dsql->GetArray()) {
            $rows[] = $row;
        }
        return $rows;
    }
}