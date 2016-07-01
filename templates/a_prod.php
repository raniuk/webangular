<div class="row">
  <div class="text-navy text-center"><h4>REGISTRO DE PRODUCTO</h4></div>
  <form enctype="multipart/form-data" class="form-horizontal formp" role="form" ng-submit="addpr.sendprod()">
    <div class="col-md-6">
      <div class="form-group">
        <label for="pronom" class="col-lg-2 control-label">Nombre</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addpr.inpro.pronom" id="pronom" placeholder="*" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="prounid" class="col-lg-2 control-label">Unidad</label>
        <div class="col-lg-10">
          <select ng-model="addpr.inpro.prounid" id="prounid" ng-options="option.value as option.name for option in listunid" class="form-control">
            <option value="" style="color: red;">Seleccione unidad</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="proprov" class="col-lg-2 control-label">Proveedor</label>
        <div class="col-lg-10">
          <select ng-model="addpr.inpro.proprov" id="proprov" ng-options="option.value as option.name for option in listprov" class="form-control">
            <option value="" style="color: red;">Seleccione proveedor</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="profech" class="col-lg-2 control-label">Fecha</label>
        <div class="col-lg-10">
          <div class="input-group">
            <input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="addpr.inpro.profech" id="profech" required="required" current-text="Hoy" toggle-weeks-text="Semana" close-text="Cerrar" clear-text="Borrar" data-show-weeks="false" placeholder="*"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="procant" class="col-lg-2 control-label">Cantidad</label>
        <div class="col-lg-10">
          <input type="number" ng-model="addpr.inpro.procant" class="form-control" id="procant" placeholder="0" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="proprec" class="col-lg-2 control-label">Precio&nbsp;(u)</label>
        <div class="col-lg-10">
          <input type="text" ng-model="addpr.inpro.proprec" class="form-control" id="proprec" placeholder="0.0" required="required">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="prodesc" class="col-lg-2 control-label">Descripción</label>
        <div class="col-lg-10">
          <textarea rows="2" class="form-control" ng-model="addpr.inpro.prodesc" id="prodesc"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="profoto" class="col-lg-2 control-label">Fotografía</label>
        <div class="col-lg-10">
          <input type="hidden" ng-model="addpr.inpro.profoto" id="auximgp">
          <input type="file" name="pimg" onchange="uploadImgp()" class="form-control" id="pimg" class="form-control" id="profoto">
        </div>
      </div>
      <div class="form-group text-center">
        <img id="imgloadp" src="../public/img/base.png" width="200px" height="160px">
        <button type="button" id="delfot" onclick="deleteImgp()" class="btn btn-danger btn-sm" style="display: none;"><i class="glyphicon glyphicon-trash"></i></button>
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
<div ng-show="alertprods">
  <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
</div>
<div ng-show="alertprode">
  <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
</div>
<div class="modal fade" id="prodModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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