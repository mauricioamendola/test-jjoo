<?php
$path = dirname(dirname(__FILE__));
include_once $path.'/includes/Lugar.php';
include_once $path.'/includes/Participante.php';

	class Agenda{
		private $Id_Agenda;
		public $Lugar;
		public $Participante;
		private $Fecha_Agenda;
		private $Hora_Agenda;
		private $Tipo_Agenda;
		private $Observaciones;

	public function __construct($Id_Agenda, $Lugar, $Participante, $Fecha_Agenda, $Hora_Agenda, $Tipo_Agenda, $Observaciones){
		$this->Id_Agenda=$Id_Agenda;
		$this->Fecha_Agenda=$Fecha_Agenda;
		$this->Hora_Agenda=$Hora_Agenda;
		$this->Observaciones=$Observaciones;
		$this->Tipo_Agenda=$Tipo_Agenda;
		$this->Lugar=$Lugar;
		$this->Participante=$Participante;
	}

	public function GetId_Agenda(){
		return $this->Id_Agenda;
	}

	public function SetId_Agenda($Id_Agenda){
		$this->Id_Agenda=$Id_Agenda;
	}

	public function GetFecha_Agenda(){
		return $this->Fecha_Agenda;
	}

	public function SetFecha_Agenda($Fecha_Agenda){
		$this->Fecha_Agenda=$Fecha_Agenda;
	}
	public function GetHora_Agenda(){
		return $this->Hora_Agenda;
	}

	public function SetHora_Agenda($Hora_Agenda){
		$this->Hora_Agenda=$Hora_Agenda;
	}

	public function GetObservaciones(){
		return $this->Observaciones;
	}
	public function SetObservaciones($Observaciones){
		$this->Observaciones=$Obervaciones;
	}

	Public function GetTipo_Agenda(){
		return $this->Tipo_Agenda;
	}

	public function SetTipo_Agenda($Tipo_Agenda){
		$this->$Tipo_Agenda=$Tipo_Agenda;
	}

	public function GetLugar(){
		return $this->Lugar;
	}

	public function SetLugar($Lugar){
		$this->Lugar=$Lugar;
	}

	public function GetParticipante(){
		return $this->Participante;
	}

	public function SetParticipante($Participante){
		$this->Participante=$Participante;
	}

	public function insertar(){
		$dbuser = "toInsert";
        $dbpass = "toInsert";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $connection->set_charset("utf8");
            echo "<br>";
            $datetime= "'".$this->Fecha_Agenda." ".$this->Hora_Agenda."'";
            $sql = "INSERT INTO actividad VALUES('$this->Id_Agenda', '$this->Lugar', '$this->Participante', $datetime, '$this->Tipo_Agenda', '$this->Observaciones')";
			echo $sql;
            $connection->query($sql);
            $connection->close();


        }
	}
}
?>
