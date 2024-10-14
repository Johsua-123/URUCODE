
<?php 
    
    $mysql = mysqli_connect("127.0.0.1", "duenio", "duenio", "urucode") or die("No se ha podido establecer la conexion con la base de datos");

    function insert($mysql, $table, $fields = [], $filters = []) {
        if (empty($table) || empty($fields)) return false;
        $sql = "INSERT INTO $table";

        $sql .= empty(array_keys($fields)) ? "" : " (" . implode(", ", array_keys($fields)) . " )";
        $sql .= empty(array_values($fields)) ? "" : " VALUES (" . implode(", ", array_values($fields)) . ")";
        
        if (!empty($filters)) $sql .= implode(" WHERE " , $filters);
        $query = mysqli_query($mysql, $sql);

        return $query && mysqli_affected_rows($mysql) > 0;
    }

    function select($mysql, $table, $fields = [], $references = [], $groupBy = [], $orderBy = [], $page = 0, $size = 25, $filters = []) {
        if (empty($table)) return false;
        $sql = "SELECT " . (empty($fields) ? "*" : implode(", ", $fields)) . " FROM $table";

        $results = [];
        if (!empty($references)) foreach ($references as $field => $value) $results[] = " $field ON $value";

        $sql .= implode(" ", $results);
        $results = [];

        if (!empty($filters)) $sql .= " WHERE " . implode(" ", $filters);
        $skip = ($page - 1) * $size;

        if ($page != 0) $sql .= " OFFSET $skip";
        $sql .= " LIMIT " . (($size != 0) ? $size : 25);

        //if (!empty($groupBy)) $sql .= " GROUP BY " . (empty($groupBy) ? "" : implode(", ", $groupBy));
        //if (!empty($orderBy)) $sql .= " ORDER BY " . implode(", ", $orderBy);
        
        $query = mysqli_query($mysql, $sql);
        if (!$query) return false;

        $results = [];
        while ($result = mysqli_fetch_assoc($query)) $results[] = $result;
        

        return [$sql, $results];
    }

    function update($mysql, $table, $fields, $references = [], $filters = []) {
        if (empty($table) || empty($fields)) return false;
        $sql = "UPDATE $table SET";

        $results = [];
        foreach($fields as $field => $value) $results[] = " $field=$value";

        $sql .= implode(", ", $results);
        $results = [];

        if (!empty($references)) foreach($references as $field => $value) $results[] = " $field ON $value";
        $sql .= implode(" ", $results);

        if (!empty($filters)) $sql .= implode(" ", $filters);
        $query = mysqli_query($mysql, $sql);

        return $query && mysqli_affected_rows($mysql) > 0;
    }

    function exists($mysql, $table, $fields = [], $references = [], $filters = [], $groupBy = []) {
        if (empty($table)) return false;
        $sql = "SELECT";

        if (empty($fields)) $sql .= " COUNT(*) AS 'total'";
        $results = [];

        if (!empty($fields)) foreach ($fields as $field => $value) $results[] = " COUNT($field) AS '$value'";
        $sql .= implode(", ", $results);

        $sql .= " FROM $table";
        if (!empty($references)) foreach ($references as $field => $value) $results[] = " $field ON $value";
        
        $sql .= implode(" ", $results);
        if (!empty($filters)) $sql .= " WHERE " . implode(" ", $filters); 

        if (!empty($groupBy)) $sql .= " GROUP BY " . implode(", ", $groupBy);
        $query = mysqli_query($mysql, $sql);

        if (!$query) return false;
        $results = [];

        while ($result = mysqli_fetch_assoc($query)) {
            $results[] = $result;
        }

        return $results[0];
    }

    function delete($mysql, $table, $filters = []) {
        if (empty($table)) return false;
        $sql = "UPDATE $table SET eliminado=true WHERE eliminado=false";

        if (!empty($filters)) $sql .= " AND ". implode(" ", $filters);
        $query = mysqli_query($mysql, $sql);

        return ($query && mysqli_affected_rows($mysql) > 0);
    }

?>