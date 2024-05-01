<?php
use config\Connect;

class Model{
    private $table;
    private $cols = [];
    private $connection;

    function __construct()
    {
        require_once "./app/config.php";
        $connectBD = new Connect();
        $this->connection = $connectBD->connectBD();
    }
    public function save($model){
        // Obtener valores
        $values = [];
        foreach ($this->cols as $col){
            $values[] = $model->$col;
        }
        // Consulta SQL
        $sql_columns = $this->table. '('. concatSQL_COLUMNS($this->cols) .') ';
        $sql_values = 'VALUES(' . concatSQL_PREP_VALUES($this->cols) . ')';
        $sql = 'INSERT INTO '. $sql_columns . $sql_values;

        // Preparar SQL
        $query = $this->connection->prepare($sql);

        // Parametros
        for ($i=0; $i < count($this->cols); $i++){
            $query->bindParam(':' . $this->cols[$i], $values[$i]);
        }
        // Guardar
        $this->connection->beginTransaction();
        $query->execute();
        $this->connection->commit();
    }
    public function get($condition){
        // Obtener valores de la cadena de texto
        $verif = strpos($condition, "=");
        $values = explode("=", $condition);
        $campo  = $values[0];
        $valor  = $values[1];

        // Verificar que exista el signo igual
        if($verif){
            $sql = "SELECT * FROM " . $this->table . " WHERE " . $campo . "= :value";
            $query = $this->connection->prepare($sql);
            $query->bindParam(':value', $valor);
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
    public function all(){
        $sql = "SELECT * FROM " . $this->table;
        $query = $this->connection->prepare($sql);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function delete($id){
        
    }
    public function update($id){

    }
    public function setCols($columns){
        foreach ($columns as $col=> $val) {
            $this->cols[] = $col;
        }
    }
    public function setTable($name){
        $this->table = $name;
    }
}

//Cargará el modelo e iniciará todo lo necesario
function loadModel($model){
    //Cargar variables
    $variables = get_object_vars($model);
    $model->setCols($variables);

    //Nombre de tabla
    $nameTable = strtolower(get_class($model));
    $model->setTable($nameTable);
}

function concatSQL_COLUMNS($cols){
    $concat_columns = "";
    $i = 0;
    foreach ($cols as $col) {
        if($i==0){
            $concat_columns= $col;
            $i = 1;
        }else{
            $concat_columns = $concat_columns . ", " . $col;
        }
    }
    return $concat_columns;
}

function concatSQL_PREP_VALUES($values){
    $concat_values = "";
    $i = 0;
    foreach ($values as $val) {
        if($i==0){
            $concat_values= " :".$val;
            $i = 1;
        }else{
            $concat_values = $concat_values . ", " . " :". $val;
        }
    }
    return $concat_values;
}
