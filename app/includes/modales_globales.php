<input type="hidden" value="iconsAccordion" id="ToggleActive">
<div class="modal fade" id="ModalAddLista" role="dialog" aria-labelledby="myModalLabel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong>Agregar opción a la lista</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <input type="hidden" id="ValueSelectedOption">
          <div class="FormDB" data-idform="25" id="FormAddListas">


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalDirecciones" role="dialog" aria-labelledby="myModalLabel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar dirección</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class=" row card-body">
          <div class="col-md-12">
            <label>Tipo de Vía</label>
            <select class="form-control" id="TipoCalles">
            </select>
          </div>
          <div class="row col-md-12 mb-2">

            <div class="col-md-4">
              <label>Vía principal</label>
              <input autocomplete="off" class="form-control" id="ViaPricipal">
            </div>
            <div class="mt-4">
              <h5 class="mt-4">#</h5>
            </div>
            <div class="col-md-4">
              <label>Vía secundaria</label>
              <input autocomplete="off" class="form-control" id="ViaSecundaria">
            </div>
            <div class="mt-4">
              <h5 class="mt-4">-</h5>
            </div>
            <div class="col-md-3">
              <label>Número</label>
              <input autocomplete="off" class="form-control" id="NumeroCalle">
            </div>
            <div class="col-md-12 mb-2">
              <label>Número Interior/ piso</label>
              <div class="input-group mb-4">
                <input autocomplete="off" type="text" class="form-control" placeholder="Ej apto 501" id="NumeroIntPiso">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <div class="n-chk align-self-end">

                      <label class="new-control new-checkbox checkbox-warning" style="height: 21px; margin-bottom: 0; margin-right: 0">
                        <input title="No tiene" id="NumPisoCheck" type="checkbox" class="new-control-input">
                        <span class="new-control-indicator"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 mb-2">
              <label>Datos complementarios</label>
              <input autocomplete="off" class="form-control" id="DatosAdd">
            </div>
            <input type="hidden" value="" id="IdField" class="form-control">
            <div class="col-md-12 mb-2 ">
              <button class="btn btn-primary float-right" id="GenerarDireccion">Guardar dirección</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalDocumentos" role="dialog" aria-labelledby="myModalLabel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <input value="1" id="DocsidPagaduria" name="idPagaduria" type="hidden">
      <input value="1" id="DocstipoVenta" name="tipoVenta" type="hidden">
        <h5 class="modal-title" id="TitleModalDocumentos"><strong>Formulario de documentos</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body" id="DivDocumentos">

        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalObservaciones" role="dialog" aria-labelledby="myModalLabel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ID Orden:<span id="IdOrdenText"></span> <strong>Historico Observaciones del cliente: <span id="NombresModalHist"></span> </strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="widget widget-three mb-1">


          <h6 id="LabelObservaciones">INGRESE OBSERVACIONES </h6>

          <input type="hidden" id="Id">
          <textarea class="form-control mb-2" id="ObservacionesText"></textarea>


          <div class="invoice-actions-btn">

            <div class="invoice-action-btn">

              <div class="row">
                <div class="col-xl-12 col-md-3 col-sm-6">
                  <a href="#" id="BtnSaveObs" class="btn btn-primary btn-send">GUARDAR OBSERVACION</a>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="card-body ObservacionesDivModal table-responsive">

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalVerificarCampos" role="dialog" aria-labelledby="myModalLabel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ID Orden:<span class="IdOrdenText"></span> <strong> Datos para validar: <span id="NombresModalHist"></span> </strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="TablaVerificarCampos" class="table table-striped" style="width:100%">
          <thead>
            <tr>
            <th>ID</th>
              <th>Nombre Campo</th>
              <th>Datos</th>
              <th>Validar</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>