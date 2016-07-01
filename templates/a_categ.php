<div class="row">
  <div class="text-navy text-center"><h4>REGISTRO DE CATEGORIA</h4></div>
  <form class="form-horizontal" role="form" ng-submit="addrc.sendCateg()">
    <div class="col col-md-12">
      <div class="form-group">
        <label for="catdesc" class="col-lg-2 control-label">Descripción</label>
        <div class="col-lg-10">
          <textarea rows="3" class="form-control" ng-model="addrc.incat.catdesc" id="catdesc" placeholder="*" required="required"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="catest" class="col-lg-2 control-label">Estado</label>
        <div class="col-lg-10">
          <select class="form-control" ng-model="addrc.incat.catest" id="catest">
            <option value="1">Activo</option>
            <option value="0">No activo</option>
          </select>
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
<div ng-show="alertcats">
  <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
</div>
<div ng-show="alertcate">
  <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
</div>