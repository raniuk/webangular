<div class="row">
  <div class="text-navy text-center"><h4>PRESTAR SERVICIOS</h4></div>
  <div class="col-md-12">
    <div class="row">
      <form class="form-horizontal" role="form">
        <div class="col-md-6">
          <select ng-model="icli" id="icli" class="form-control" ng-options="option.codec as option.namec for option in clientes">
            <option value="" style="color: red;">Seleccionar cliente</option>
          </select>
        </div>
        <div class="col-md-3">
          <select ng-model="cbank" id="cbank" class="form-control">
            <option value="" style="color: red;">Seleccione cuenta bancaria</option>
            <option value="1">Banco Nacional de Bolivia</option>
            <option value="2">Otro Banco</option>
          </select>
        </div>
        <div class="col-md-3">
          <button type="button" class="btn btn-block btn-primary btn-flat" ng-click="sendServ()">Verificar servicios</button>
        </div>
      </form>
    </div>
  </div><br><br>
  <div id="itemserv" class="contentserv col-md-12">
    <accordion>
      <accordion-group heading="{{datoc.desc}}" class="box box-primary" ng-repeat="datoc in listcat" style="cursor: hand;">
        <ul class="todo-list">
          <li ng-repeat="datos in datoc.servs">
            <input type="checkbox" id="abc" value="{{datos.iser}}" name="{{datoc.icat}}">
            <span class="text" for="abc">{{datos.desc}}</span>
          </li>        
        </ul>
      </accordion-group>
    </accordion>
  </div>
</div>
<div class="modal fade" id="sfactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-alert"></span> Alerta de validación</h4>
      </div>
      <div class="modal-body text-center">
        <h4>{{notificacion}}</h4>            
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalSFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-alert"></span> CONFIRMACIÓN</h4>
      </div>
      <form name="formps" method="POST" action="../pdf/sfactura.php" target="_blank" ng-submit="addps.facturarServ()">
        <div class="modal-body text-center">
          <span>Seguro de prestar los servicios seleccionados?</span>
          <p>No se podra revertir los servicios a prestar, por que se asignará un número de serie</p>
          <label>Forma de pago</label>
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="addps.inpsr.formu"></div>
            <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="addps.inpsr.detau"></textarea></div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="addps.inpsr.formd"></div>
            <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="addps.inpsr.detad"></textarea></div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="addps.inpsr.formt"></div>
            <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="addps.inpsr.detat"></textarea></div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="addps.inpsr.formc"></div>
            <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="addps.inpsr.detac"></textarea></div>
          </div><br>
          <div class="form-group">
            <label for="tempoe">Tiempo de entrega</label>
              <input type="text" class="form-control text-center" ng-model="addps.inpsr.tempoe" id="tempoe" placeholder="24 hrs, 1 día, ..." required="required">
          </div>
          <div class="form-group">
            <label for="lugar">Lugar de trabajo</label>
              <input type="text" class="form-control text-center" ng-model="addps.inpsr.lugar" id="lugar" placeholder="dirección" required="required">
          </div>
          <div class="form-group">
            <label for="descus">Descuento (%)</label>
              <input type="text" class="form-control text-center" ng-model="addps.inpsr.descus" id="descus" placeholder="0, 1, 2, ..." required="required">
          </div>
          <div class="form-group">
            <label for="valid">Validez de la oferta</label>
              <select class="form-control text-center" ng-model="addps.inpsr.valid" id="valid" required="required">
                <option value="15">15 días</option>
                <option value="30">30 días</option>
                <option value="60">60 días</option>
                <option value="90">90 días</option>
              </select>
          </div><br>
          <input type="hidden" name="rcli">
          <input type="hidden" name="rservs">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-flat"><i>SI, Generar formulario</i></button>
          <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal"><i>NO, Cancelar</i></button>
        </div>
      </form>
    </div>
  </div>
</div>