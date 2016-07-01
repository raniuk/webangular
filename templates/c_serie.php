<div class="row">
  <div class="text-navy text-center"><h4>GESTIONAR SERIES</h4></div><br>
  <div class="text-center"><h4>El número de serie es el identificador único de formularios y debe ser administrado con mucha cautela.</h4></div><br>
  <div class="col col-lg-6 col-md-6">
    <form class="form-horizontal" role="form">
      <div class="form-group">
        <label for="sventa" class="col-lg-4 control-label">Serie de ventas</label>
        <div class="col-lg-8">
          <input type="number" min="1" class="form-control" ng-model="sventa" id="sventa" placeholder="*" required="required">
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group text-center">
          <div class="col-lg-12">
            <button class="btn btn-primary btn-flat btn-lg" ng-click="sendSVent()"><span class="glyphicon glyphicon-ok"></span><i> Guardar</i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col col-lg-6 col-md-6">
    <form class="form-horizontal" role="form">
      <div class="form-group">
        <label for="sservi" class="col-lg-4 control-label">Serie de servicios</label>
        <div class="col-lg-8">
          <input type="number" min="1" class="form-control" ng-model="sservi" id="sservi" placeholder="*" required="required">
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group text-center">
          <div class="col-lg-12">
            <button type="button" class="btn btn-primary btn-flat btn-lg" ng-click="sendSServ()"><span class="glyphicon glyphicon-ok"></span><i> Guardar</i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<div ng-show="alertseris">
  <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
</div>
<div ng-show="alertserie">
  <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
</div>
  <div class="modal fade" id="serieModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-alert"></span> Alerta de notificación</h4>
        </div>
        <div class="modal-body text-center">
          <h4>{{notificacion}}</h4>            
        </div>
      </div>
    </div>
  </div>