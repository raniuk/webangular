<div class="row">
  <div class="text-navy text-center"><h4>REGISTRO DE CLIENTE</h4></div>
  <form class="form-horizontal" role="form" ng-submit="addrl.sendClie()">
    <div class="col-md-6">
      <div class="form-group">
        <label for="clinom" class="col-lg-2 control-label">Nombre cliente</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addrl.incli.clinom" id="clinom" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="clinit" class="col-lg-2 control-label">CI / NIT</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addrl.incli.clinit" id="clinit" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="clitelf" class="col-lg-2 control-label">Teléfono</label>
        <div class="col-lg-10">
          <input type="number" class="form-control" ng-model="addrl.incli.clitelf" id="clitelf" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="clicelu" class="col-lg-2 control-label">Celular</label>
        <div class="col-lg-10">
          <input type="number" class="form-control" ng-model="addrl.incli.clicelu" id="clicelu">
        </div>
      </div>
      <div class="form-group">
        <label for="climail" class="col-lg-2 control-label">Correo</label>
        <div class="col-lg-10">
          <input type="email" class="form-control" ng-model="addrl.incli.climail" id="climail">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="clitipo" class="col-lg-2 control-label">Tipo</label>
        <div class="col-lg-10">
          <select ng-model="addrl.incli.clitipo" ng-change="funcTipo(addrl.incli.clitipo)" id="clitipo" class="form-control">
            <option value="" style="color: red;">Seleccione tipo cliente</option>
            <option value="1">Empresa</option>
            <option value="0">Persona</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="clirazs" class="col-lg-2 control-label">Razon Social</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addrl.incli.clirazs" id="clirazs" ng-disabled="actrs">
        </div>
      </div>
      <div class="form-group">
        <label for="cliciu" class="col-lg-2 control-label">Ciudad</label>
        <div class="col-lg-10">
          <select ng-model="addrl.incli.cliciu" id="cliciu" ng-options="option.value as option.name for option in procity" class="form-control">
            <option value="" style="color: red;">Seleccione ciudad</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="clidir" class="col-lg-2 control-label">Dirección</label>
        <div class="col-lg-10">
          <textarea rows="3" class="form-control" ng-model="addrl.incli.clidir" id="clidir"></textarea>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group text-center">
        <div class="col-lg-12">
          <button class="btn btn-primary btn-flat btn-lg"><span class="glyphicon glyphicon-ok"></span><i> Guardar</i></button>
        </div>
      </div>
    </div>
  </form>
</div>
<div ng-show="alertclis">
    <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
  </div>
  <div ng-show="alertclie">
    <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
  </div>
  <div class="modal fade" id="clieModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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