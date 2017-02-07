<?php
class Persona {
    Private $Id_Persona;
    Private $Primer_Nombre;
    Private $Primer_Apellido;
    Private $Sexo;
    Private $Correo_Persona;
    Private $Nombre_Usuario;
    Private $Password;

    public function __construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password){
        $this->Id_Persona=$Id_Persona;
        $this->Primer_Nombre=$Primer_Nombre;
        $this->Primer_Apellido=$Primer_Apellido;
        $this->Correo_Persona=$Correo_Persona;
        $this->Nombre_Usuario=$Nombre_Usuario;
        $this->Sexo=$Sexo;
        $this->Password=$Password;
    }

    Public function GetId_Persona(){
                    return $this->Id_Persona;
    }

    Public function SetId_Persona($Id_Persona){
        $this->Id_Persona=$Id_Persona;
    }

    Public function GetPrimer_Nombre(){
        return $this->Primer_Nombre;
    }

    Public function SetPrimer_Nombre($Primer_Nombre){
        $this->Primer_Nombre->$Primer_Nombre;
    }

    Public function GetPrimer_Apellido(){
        return $this->Primer_Apellido;
    }

    Public function SetSexo($Sexo){
        $this->Sexo->$Sexo;
    }

    Public function GetSexo(){
        return $this->Sexo;
    }

    Public function SetPrimer_Apellido($Primer_Apellido){
        $this->Primer_Apellido=$Primer_Apellido;
    }

    Public function GetCorreo_Persona(){
        return $this->Correo_Persona;
    }

    Public function SetCorreo_Persona($Correo_Persona){
        $this->Correo_Persona=$Correo_Persona;
    }

    Public function GetNombre_Usuario(){
        return $this->Nombre_Usuario;
    }

    Public function SetNombre_Usuario($Nombre_Usuario){
        $this->Nombre_Usuario=$Nombre_Usuario;
    }

    Public function GetPassword(){
        return $this->Password;
    }

    Public function SetPassword($Password){
        $this->Password=$Password;
    }
}
?>
