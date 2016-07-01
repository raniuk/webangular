<div class="row">
  <div class="text-navy text-center"><h4>REGISTRO DE SERVICIO</h4></div>
  <form class="form-horizontal" role="form" ng-submit="addrs.sendServ()">
    <div class="col-md-12">
      <div class="form-group">
        <label for="serdes" class="col-lg-2 control-label">Descripción</label>
        <div class="col-lg-10">
          <textarea class="form-control" ng-model="addrs.inser.serdes" id="serdes" placeholder="*" required="required"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="sercat" class="col-lg-2 control-label">Categoria</label>
        <div class="col-lg-10">
          <select ng-model="addrs.inser.sercat" id="sercat" ng-options="option.value as option.name for option in categs" class="form-control">
            <option value="" style="color: red;">Seleccione categoria</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="serfech" class="col-lg-2 control-label">Fecha</label>
        <div class="col-lg-10">
          <div class="input-group">
            <input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="addrs.inser.serfech" id="serfech" current-text="Hoy" toggle-weeks-text="Semana" close-text="Cerrar" clear-text="Borrar" data-show-weeks="false" placeholder="*" required="required"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="sercos" class="col-lg-2 control-label">Costo</label>
        <div class="col-lg-10">
          <input type="text" ng-model="addrs.inser.sercos" class="form-control" id="sercos" placeholder="0.0" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="serobs" class="col-lg-2 control-label">Observación</label>
        <div class="col-lg-10">
          <input type="text" ng-model="addrs.inser.serobs" class="form-control" id="serobs">
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
<div ng-show="alertservs">
  <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
</div>
<div ng-show="alertserve">
  <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
</div>
<div class="modal fade" id="servModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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