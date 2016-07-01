<div class="row">
  <div class="text-navy text-center"><h4>REGISTRO DE PROVEEDOR</h4></div>
  <form class="form-horizontal" role="form" ng-submit="addpv.sendprov()">
    <div class="col-md-6">
      <div class="form-group">
        <label for="prvnom" class="col-lg-2 control-label">Empresa</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addpv.inprv.prvnom" id="prvnom" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="prvnit" class="col-lg-2 control-label">NIT</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addpv.inprv.prvnit" id="prvnit" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="prvcont" class="col-lg-2 control-label">Contacto(s)</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addpv.inprv.prvcont" id="prvcont">
        </div>
      </div>
      <div class="form-group">
        <label for="prvpais" class="col-lg-2 control-label">Pais</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addpv.inprv.prvpais" id="prvpais">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="prvtelf" class="col-lg-2 control-label">Teléfono</label>
        <div class="col-lg-10">
          <input type="number" ng-model="addpv.inprv.prvtelf" class="form-control" id="prvtelf">
        </div>
      </div>
      <div class="form-group">
        <label for="prvcel" class="col-lg-2 control-label">Movil</label>
        <div class="col-lg-10">
          <input type="number" ng-model="addpv.inprv.prvcel" class="form-control" id="prvcel">
        </div>
      </div>
      <div class="form-group">
        <label for="prvdir" class="col-lg-2 control-label">Dirección</label>
          <div class="col-lg-10">
            <textarea rows="3" ng-model="addpv.inprv.prvdir" class="form-control" id="prvdir"></textarea>
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
  <div ng-show="alertprovs">
    <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
  </div>
  <div ng-show="alertprove">
    <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
  </div>
</div>