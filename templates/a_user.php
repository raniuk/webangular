<div class="row">
  <div class="text-navy text-center"><h4>REGISTRO DE USUARIO</h4></div>
  <form class="form-horizontal" role="form" ng-submit="addru.sendUser()">
    <div class="col-md-6">
      <div class="form-group">
        <label for="useuse" class="col-lg-2 control-label">Usuario</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addru.inuse.useuse" id="useuse" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="usecon" class="col-lg-2 control-label">Contraseña</label>
        <div class="col-lg-10">
          <input type="password" class="form-control" ng-model="addru.inuse.usecon" id="usecon" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="usenom" class="col-lg-2 control-label">Nombre completo</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addru.inuse.usenom" id="usenom" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="usedni" class="col-lg-2 control-label">Cédula identidad</label>
        <div class="col-lg-6">
          <input type="number" class="form-control" ng-model="addru.inuse.usedni" id="usedni" placeholder="*" required="required">
        </div>
        <div class="col-lg-4">
          <select ng-model="addru.inuse.usepro" id="usepro" ng-options="option.value as option.name for option in procity" class="form-control">
            <option value="" style="color: red;">...</option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="usecar" class="col-lg-2 control-label">Cargo</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addru.inuse.usecar" id="usecar" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="usetel" class="col-lg-2 control-label">Teléfono</label>
        <div class="col-lg-10">
          <input type="number" class="form-control" ng-model="addru.inuse.usetel" id="usetel" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="climail" class="col-lg-2 control-label">Correo</label>
        <div class="col-lg-10">
          <input type="email" class="form-control" ng-model="addru.inuse.climail" id="climail" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="clidir" class="col-lg-2 control-label">Dirección</label>
        <div class="col-lg-10">
          <textarea rows="2" class="form-control" ng-model="addru.inuse.clidir" id="clidir" placeholder="*" required="required"></textarea>
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
<div ng-show="alertuses">
  <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
</div>
<div ng-show="alertusee">
  <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
</div>
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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