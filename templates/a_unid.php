<div class="row">
  <div class="text-navy text-center"><h4>GESTIONAR UNIDAD</h4></div>
  <div class="col-md-4">
    <form class="form-horizontal" role="form" ng-submit="addun.sendUnid()">
      <div class="form-group">
        <label for="unid" class="col-lg-2 control-label">Unidad</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" ng-model="addun.inuni.unid" id="unid" placeholder="*" required="required">
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
  <div class="col-md-8">
    <div class="table-info">
      <div class="row">
        <!-- <div class="col-md-4 col-sm-3">
          <div class="form-group">
            <form name="formlun" action="../pdf/unidad.php" method="POST" target="_blank">
              <p class="text-primary">Exportar: <button ng-click="prn_categorias()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/pdf.png" width="20px" height="20px" title="PDF"></button></p>
              <input type="hidden" name="rdesc">
              <input type="hidden" name="resta">
            </form>
          </div>
        </div> -->
        <div class="col-md-4 col-sm-4">
          <div class="form-group">
            <select ng-model="entryLimitun" class="form-control" ng-options="option.value as option.nombre for option in limites">
            </select>
          </div>
        </div>
        <div class="col-md-8 col-sm-8">
          <div class="form-group">
            <input type="text" ng-model="search" ng-change="filter()" placeholder="Buscar..." class="form-control" />
          </div>
        </div>
      </div>
      <div class="table-responsive" id="datalcat" ng-show="filteredItems > 0">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
          <thead class="bg-light-blue">
            <tr>
              <th>N&nbsp;°</th>
              <th>Descripción&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('uni');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th><center>Estado&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('esta');"><i class="glyphicon glyphicon-sort"></i></a></center></th>
              <th><center>Acciones</center></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datun in filtered = (listun | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimitun | limitTo:entryLimitun">
              <td>{{datun.num}}</td>
              <td>{{datun.uni}}</td>
              <td class="text-center"><span class="label {{datun.esti}}">{{datun.estn}}</span></td>
              <td class="text-center">
                <button ng-click="editUnid(datun.iun,datun.uni,datun.est)" class="btn btn-info btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                <button ng-click="deleteUnid(datun.iun)" class="btn btn-danger btn-xs delete"><i class="glyphicon glyphicon-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="row text-center" style="margin-top: 5px">
        <div class="col-sm-5" ng-show="filteredItems > 0">
          <div class="dataTables_info"><code>Mostrando {{ filtered.length }} de {{ totalItems }}</code></div>
        </div>
        <div class="col-sm-7">
          <div class="col-md-12" ng-show="filteredItems == 0">
            <div class="col-md-12">
              <code>No existen datos !!!</code>
            </div>
          </div>
          <div class="col-md-12" ng-show="filteredItems > 0">
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimitun" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/ng-template" id="modalUni">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelun()"><span aria-hidden="true">&times;</span></button>
      <strong class="text-info"><i>DATOS UNIDAD</i></strong>
    </div>
    <div class="modal-body">
      <form class="form-horizontal" role="form">
        <div class="form-group">
          <label for="desun" class="col-lg-2 control-label">Descripción</label>
          <div class="col-lg-10">
            <textarea rows="3" class="form-control" ng-model="uni.desun" id="desun" required="true"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="estun" class="col-lg-2 control-label">Estado</label>
          <div class="col-lg-10">
            <select ng-model="uni.estun" id="estun" class="form-control">
              <option value="1">Activo</option>
              <option value="0">No activo</option>
            </select>
          </div>
        </div>          
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary btn-flat" ng-click="updateUnid(uni)"><i>Actualizar</i></button>
      <button class="btn btn-warning btn-flat" ng-click="cancelun()"><i>Cancelar</i></button>
    </div>
  </div>
</script>
<div ng-show="alertunis">
    <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
  </div>
  <div ng-show="alertunie">
    <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
  </div>
  <div class="modal fade" id="provModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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