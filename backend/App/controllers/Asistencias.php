<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\PruebasCovidSitio as PruebasCovidSitioDao;
use \App\models\Asistencias as AsistenciasDao;
use \DateTime;
use \DatetimeZone;
// use \App\models\Linea as LineaDao;

class Asistencias extends Controller
{

  private $_contenedor;

  function __construct()
  {
    parent::__construct();
    $this->_contenedor = new Contenedor;
    View::set('header', $this->_contenedor->header());
    View::set('footer', $this->_contenedor->footer());
    // if (Controller::getPermisosUsuario($this->__usuario, "seccion_asistencias", 1) == 0)
    //   header('Location: /Principal/');
  }

  public function getUsuario()
  {
    return $this->__usuario;
  }

  public function index()
  {
    $extraHeader = <<<html
html;
    $permisoGlobalHidden = (Controller::getPermisoGlobalUsuario($this->__usuario)[0]['permisos_globales']) != 1 ? "style=\"display:none;\"" : "";
    $asistentesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistentes", 1) == 0) ? "style=\"display:none;\"" : "";
    $vuelosHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vuelos", 1) == 0) ? "style=\"display:none;\"" : "";
    $pickUpHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pickup", 1) == 0) ? "style=\"display:none;\"" : "";
    $habitacionesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_habitaciones", 1) == 0) ? "style=\"display:none;\"" : "";
    $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1) == 0) ? "style=\"display:none;\"" : "";
    $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1) == 0) ? "style=\"display:none;\"" : "";
    $aistenciasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistencias", 1) == 0) ? "style=\"display:none;\"" : "";
    $vacunacionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vacunacion", 1) == 0) ? "style=\"display:none;\"" : "";
    $pruebasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pruebas_covid", 1) == 0) ? "style=\"display:none;\"" : "";
    $configuracionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_configuracion", 1) == 0) ? "style=\"display:none;\"" : "";
    $utileriasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_utilerias", 1) == 0) ? "style=\"display:none;\"" : "";

    $extraFooter =<<<html
html;

      View::set('asideMenu',$this->_contenedor->asideMenu());
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("asistencias_menu");
    }

    public function Foro($asistencia = null){
      $extraHeader = <<<html
html;
          $permisoGlobalHidden = (Controller::getPermisoGlobalUsuario($this->__usuario)[0]['permisos_globales']) != 1 ? "style=\"display:none;\"" : "";
          $asistentesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistentes", 1) == 0) ? "style=\"display:none;\"" : "";
          $vuelosHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vuelos", 1) == 0) ? "style=\"display:none;\"" : "";
          $pickUpHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pickup", 1) == 0) ? "style=\"display:none;\"" : "";
          $habitacionesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_habitaciones", 1) == 0) ? "style=\"display:none;\"" : "";
          $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1) == 0) ? "style=\"display:none;\"" : "";
          $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1) == 0) ? "style=\"display:none;\"" : "";
          $aistenciasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistencias", 1) == 0) ? "style=\"display:none;\"" : "";
          $vacunacionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vacunacion", 1) == 0) ? "style=\"display:none;\"" : "";
          $pruebasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pruebas_covid", 1) == 0) ? "style=\"display:none;\"" : "";
          $configuracionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_configuracion", 1) == 0) ? "style=\"display:none;\"" : "";
          $utileriasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_utilerias", 1) == 0) ? "style=\"display:none;\"" : "";
      
      $extraFooter =<<<html
            <script>
              $(document).ready(function(){
      
                $('#asistencia-list').DataTable({
                  "drawCallback": function(settings) {
                      $('.current').addClass("btn btn-blue-cardio btn-rounded").removeClass("paginate_button");
                      $('.paginate_button').addClass("btn").removeClass("paginate_button");
                      $('.dataTables_length').addClass("m-4");
                      $('.dataTables_info').addClass("mx-4");
                      $('.dataTables_filter').addClass("m-4");
                      $('input').addClass("form-control");
                      $('select').addClass("form-control");
                      $('.previous.disabled').addClass("btn-outline-cardio opacity-5 btn-rounded mx-2");
                      $('.next.disabled').addClass("btn-outline-cardio opacity-5 btn-rounded mx-2");
                      $('.previous').addClass("btn-outline-cardio btn-rounded mx-2");
                      $('.next').addClass("btn-outline-cardio btn-rounded mx-2");
                      $('a.btn').addClass("btn-rounded");
                  },
                  "language": {
      
                      "sProcessing": "Procesando...",
                      "sLengthMenu": "Mostrar _MENU_ registros",
                      "sZeroRecords": "No se encontraron resultados",
                      "sEmptyTable": "Ning??n dato disponible en esta tabla",
                      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "sInfoPostFix": "",
                      "sSearch": "Buscar:",
                      "sUrl": "",
                      "sInfoThousands": ",",
                      "sLoadingRecords": "Cargando...",
                      "oPaginate": {
                          "sFirst": "Primero",
                          "sLast": "??ltimo",
                          "sNext": "Siguiente",
                          "sPrevious": "Anterior"
                      },
                      "oAria": {
                          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                      }
      
                  }
              });
      
                $("#muestra-cupones").tablesorter();
                var oTable = $('#muestra-cupones').DataTable({
                      "columnDefs": [{
                          "orderable": false,
                          "targets": 0
                      }],
                       "order": false
                  });
      
                  // Remove accented character from search input as well
                  $('#muestra-cupones input[type=search]').keyup( function () {
                      var table = $('#example').DataTable();
                      table.search(
                          jQuery.fn.DataTable.ext.type.search.html(this.value)
                      ).draw();
                  });
      
                  var checkAll = 0;
                  $("#checkAll").click(function () {
                    if(checkAll==0){
                      $("input:checkbox").prop('checked', true);
                      checkAll = 1;
                    }else{
                      $("input:checkbox").prop('checked', false);
                      checkAll = 0;
                    }
      
                  });
      
                  $("#export_pdf").click(function(){
                    $('#all').attr('action', '/Empresa/generarPDF/');
                    $('#all').attr('target', '_blank');
                    $("#all").submit();
                  });
      
                  $("#export_excel").click(function(){
                    $('#all').attr('action', '/Empresa/generarExcel/');
                    $('#all').attr('target', '_blank');
                    $("#all").submit();
                  });
      
                  $("#delete").click(function(){
                    var seleccionados = $("input[name='borrar[]']:checked").length;
                    if(seleccionados>0){
                      alertify.confirm('??Seg??ro que desea eliminar lo seleccionado?', function(response){
                        if(response){
                          $('#all').attr('target', '');
                          $('#all').attr('action', '/Empresa/delete');
                          $("#all").submit();
                          alertify.success("Se ha eliminado correctamente");
                        }
                      });
                    }else{
                      alertify.confirm('Selecciona al menos uno para eliminar');
                    }
                  });
      
              });
            </script>
html;
          $tabla = '';
          $datos = AsistenciasDao::getAllA($asistencia);
          
          foreach ($datos as $key => $value) {
        
            $tabla.=<<<html
            <tr>
              <td>{$value['nombre']}</td>
              <td id="descripcion_asistencia" width="20">{$value['descripcion']}</td>
              <td class="text-center">{$value['fecha_asistencia']}</td>
              <td class="text-center">{$value['hora_asistencia_inicio']}</td>
              <td class="text-center"><i class='fa-alarm-clock'></i>{$value['hora_asistencia_fin']}</td>
              <td class="text-center">
              <a href='{$value['url']}' style='' class='mx-2' data-bs-toggle="tooltip" target="_blank" data-bs-placement="left" data-bs-original-title="Asistencia Web - {$value['nombre']}"><i class='fas fa-globe'></i></a>
              <a href='/ListaAsistencia/codigo/{$value['clave']}' style='' class='mx-2' target="_blank"><i class='fas fa-list-alt' data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Lista de Asistencia - {$value['nombre']}"></i></a>
              <a href='https://asistencias.foromusa.com/?asistencia={$value['clave']}' class='mx-2' target="_blank" style='' target='_blank' data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Asistencia M??vil - {$value['nombre']}"><i class='fas fa-mobile-alt'></i></a>
              </td>
            </tr>
       
      html;
          }
          
          $modal = '';
          $tema_foro = '';
          $num_asistencias = AsistenciasDao::getNumAsistencias()['total'];
          $date = date("Y").'-'.date("m").'-'.date("d");

          if($asistencia == 1){
            $tema_foro.=<<<html
          Foro Hematolog??a
html;
            $modal .=<<< html
          <div class="modal fade" id="Modal_Add" role="dialog" aria-labelledby="asignar_habitacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" id="add" action="/Asistencias/asistenciasAddHema" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="asignar_habitacionLabel">Generar Lista de Asistencia Foro Hematolog??a</h5>
                            <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body pt-0">
                                <div class="row mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <div class="input-group">
                                        <input id="nombre" name="nombre" class="form-control" type="text" placeholder="Asistencia Plenaria Bienvenida" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="form-label">Descripci??n (Opcional)</label>
                                    <div class="input-group">
                                        <textarea id="descripcion" name="descripcion" maxlength="1000" class="form-control" placeholder="Descripci??n"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="form-label">Fecha *</label>
                                    <div class="input-group">
                                        <input id="fecha_asistencia" name="fecha_asistencia" maxlength="29" class="form-control" type="date" min required="" onfocus="focused(this)" onfocusout="defocused(this)"" style=" text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Hora Asistencia (Inicio) *</label>
                                    <div class="input-group">
                                        <input id="hora_asistencia_inicio" name="hora_asistencia_inicio" maxlength="29" class="form-control" type="time" required="" onfocus="focused(this)" onfocusout="defocused(this)"" style=" text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Hora Asistencia (Fin) *</label>
                                    <div class="input-group">
                                        <input id="hora_asistencia_fin" name="hora_asistencia_fin" maxlength="29" class="form-control" type="time" required="" onfocus="focused(this)" onfocusout="defocused(this)"" style=" text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-success" id="btn_upload" name="btn_upload">Aceptar</button>
                            <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
html;

          }else{
          $tema_foro.=<<<html
          Foro Oncolog??a
html;
          $modal .=<<< html
          <div class="modal fade" id="Modal_Add" role="dialog" aria-labelledby="asignar_habitacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" id="add" action="/Asistencias/asistenciasAddOnco" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="asignar_habitacionLabel">Generar Lista de Asistencia Foro Oncolog??a</h5>
                            <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body pt-0">
                                <div class="row mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <div class="input-group">
                                        <input id="nombre" name="nombre" class="form-control" type="text" placeholder="Asistencia Plenaria Bienvenida" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="form-label">Descripci??n (Opcional)</label>
                                    <div class="input-group">
                                        <textarea id="descripcion" name="descripcion" maxlength="1000" class="form-control" placeholder="Descripci??n"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="form-label">Fecha *</label>
                                    <div class="input-group">
                                        <input id="fecha_asistencia" name="fecha_asistencia" maxlength="29" class="form-control" type="date" min required="" onfocus="focused(this)" onfocusout="defocused(this)"" style=" text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Hora Asistencia (Inicio) *</label>
                                    <div class="input-group">
                                        <input id="hora_asistencia_inicio" name="hora_asistencia_inicio" maxlength="29" class="form-control" type="time" required="" onfocus="focused(this)" onfocusout="defocused(this)"" style=" text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Hora Asistencia (Fin) *</label>
                                    <div class="input-group">
                                        <input id="hora_asistencia_fin" name="hora_asistencia_fin" maxlength="29" class="form-control" type="time" required="" onfocus="focused(this)" onfocusout="defocused(this)"" style=" text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-success" id="btn_upload" name="btn_upload">Aceptar</button>
                            <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
html;
}
            View::set('tabla',$tabla);
            View::set('modal',$modal);
            View::set('tema_foro',$tema_foro);
            View::set('num_asistencias',$num_asistencias);
            View::set('asideMenu',$this->_contenedor->asideMenu());
            View::set('header',$this->_contenedor->header($extraHeader));
            View::set('footer',$this->_contenedor->footer($extraFooter));
            View::render("asistencias_all");
    }
  

    public function asistenciasAddHema() {

      $data = new \stdClass();
      $data->_clave = $this->generateRandomString();
      $data->_nombre = MasterDom::getData('nombre');
      $data->_descripcion = MasterDom::getData('descripcion');
      $data->_fecha_asistencia = MasterDom::getData('fecha_asistencia');
      $data->_hora_asistencia_inicio = MasterDom::getData('hora_asistencia_inicio');
      $data->_hora_asistencia_fin = MasterDom::getData('hora_asistencia_fin');
      $data->_utilerias_administrador_id = $_SESSION['utilerias_administradores_id'];
      $data->_url = "/RegistroAsistencia/codigo/".$data->_clave;
  
      $id = AsistenciasDao::insertHema($data);
      if($id >= 1){
        // $this->alerta($id,'add');
        echo '<script>
          alert("Asistencia Registrada con exito");
          window.location.href = "/Asistencias/Foro/1/";
        </script>';

       
      }else{
        // $this->alerta($id,'error');
        echo '<script>
        alert("Error al registrar la aistencia, consulte a soporte");
        window.location.href = "/Asistencias/Foro/1/";
      </script>';
      }

    }

    public function asistenciasAddOnco() {

      $data = new \stdClass();
      $data->_clave = $this->generateRandomString();
      $data->_nombre = MasterDom::getData('nombre');
      $data->_descripcion = MasterDom::getData('descripcion');
      $data->_fecha_asistencia = MasterDom::getData('fecha_asistencia');
      $data->_hora_asistencia_inicio = MasterDom::getData('hora_asistencia_inicio');
      $data->_hora_asistencia_fin = MasterDom::getData('hora_asistencia_fin');
      $data->_utilerias_administrador_id = $_SESSION['utilerias_administradores_id'];
      $data->_url = "/RegistroAsistencia/codigo/".$data->_clave;
  
      $id = AsistenciasDao::insertOnco($data);
      if($id >= 1){
        // $this->alerta($id,'add');
        echo '<script>
          alert("Asistencia Registrada con exito");
          window.location.href = "/Asistencias/Foro/2/";
        </script>';

       
      }else{
        // $this->alerta($id,'error');
        echo '<script>
        alert("Error al registrar la aistencia, consulte a soporte");
        window.location.href = "/Asistencias/Foro/2/";
      </script>';
      }

    }


    public function alerta($id, $parametro){
      $regreso = "/Asistencias/";

      if($parametro == 'add'){
        $mensaje = "Se ha agregado correctamente";
        $class = "success";
      }

      if($parametro == 'edit'){
        $mensaje = "Se ha modificado correctamente";
        $class = "success";
      }

      if($parametro == 'nothing'){
        $mensaje = "Al parecer no intentaste actualizar ning??n campo";
        $class = "warning";
      }

      if($parametro == 'union'){
        $mensaje = "Al parecer este campo de est?? ha sido enlazada con un campo de Cat??logo de Colaboradores, ya que esta usuando esta informaci??n";
        $class = "info";
      }

      if($parametro == "error"){
        $mensaje = "Al parecer ha ocurrido un problema";
        $class = "danger";
      }


      View::set('class',$class);
      View::set('regreso',$regreso);
      View::set('mensaje',$mensaje);
      // View::set('header',$this->_contenedor->header($extraHeader));
      // View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("alerta");
    }



    function generateRandomString($length = 6) { 
      return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
  } 

  // View::set('permisoGlobalHidden', $permisoGlobalHidden);
  // View::set('asistentesHidden', $asistentesHidden);
  // View::set('vuelosHidden', $vuelosHidden);
  // View::set('pickUpHidden', $pickUpHidden);
  // View::set('habitacionesHidden', $habitacionesHidden);
  // View::set('cenasHidden', $cenasHidden);
  // View::set('aistenciasHidden', $aistenciasHidden);
  // View::set('vacunacionHidden', $vacunacionHidden);
  // View::set('pruebasHidden', $pruebasHidden);
  // View::set('configuracionHidden', $configuracionHidden);
  // View::set('utileriasHidden', $utileriasHidden);
  // View::set('header', $this->_contenedor->header($extraHeader));
  // View::set('footer', $this->_contenedor->footer($extraFooter));
  // View::render("asistencias_all");

}
