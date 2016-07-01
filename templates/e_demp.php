<div class="row">
  <div class="text-navy text-center"><h4>DATOS DE EMPRESA</h4></div>
  <form class="form-horizontal" role="form">
    <div class="col col-md-12">
      <div class="form-group">
        <label for="raz" class="col-lg-2 control-label">Razon sosial</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.raz" id="raz" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="num" class="col-lg-2 control-label">Número</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.num" id="num" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="zon" class="col-lg-2 control-label">Zona</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.zon" id="zon" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="tel" class="col-lg-2 control-label">Teléfono</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.tel" id="tel" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="mai" class="col-lg-2 control-label">Correo</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.mai" id="mai" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="ban" class="col-lg-2 control-label">Banco</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.ban" id="ban" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="cun" class="col-lg-2 control-label">Cuenta MN</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.cun" id="cun" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="cue" class="col-lg-2 control-label">Cuenta ME</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.cue" id="cue" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="band" class="col-lg-2 control-label">Banco 2</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.band" id="band" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="cund" class="col-lg-2 control-label">Cuenta MN 2</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.cund" id="cund" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="cued" class="col-lg-2 control-label">Cuenta ME 2</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="inemp.cued" id="cued" placeholder="*" required="required">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group text-center">
        <div class="col-lg-12">
          <button class="btn btn-primary btn-flat btn-lg" ng-click="updateEmp(inemp)"><span class="glyphicon glyphicon-ok"></span><i> Actualizar</i></button>
        </div>
      </div>
    </div>
  </form>
</div>
<div ng-show="alertemps">
  <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
</div>
<div ng-show="alertempe">
  <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
</div>