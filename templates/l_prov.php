<div class="row">
  <div class="text-navy text-center"><h4>LISTA DE PROVEEDORES</h4></div>
  <div class="col-md-12">
    <div class="table-info">
      <div class="row">
        <div class="col-md-4 col-sm-3">
          <div class="form-group">
            <form name="formlprv" action="../pdf/proveedores.php" method="POST" target="_blank">
              <p class="text-primary">Exportar: <button ng-click="prn_proveedor()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/pdf.png" width="20px" height="20px" title="PDF"></button></p>
              <input type="hidden" name="rnomb">
              <input type="hidden" name="rnit">
              <input type="hidden" name="rcont">
              <input type="hidden" name="rpais">
              <input type="hidden" name="rtefl">
              <input type="hidden" name="rdire">
              <input type="hidden" name="resta">
            </form>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="form-group">
            <select ng-model="entryLimitprv" class="form-control" ng-options="option.value as option.nombre for option in limites">
            </select>
          </div>
        </div>
        <div class="col-md-5 col-sm-5">
          <div class="form-group">
            <input type="text" ng-model="search" ng-change="filter()" placeholder="Buscar..." class="form-control" />
          </div>
        </div>
      </div>
      <div class="table-responsive" id="datalprv" ng-show="filteredItems > 0">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
          <thead class="bg-light-blue">
            <tr>
              <th>N&nbsp;°</th>
              <th>Razon&nbsp;social&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('name');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>NIT&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('nit');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Contacto(s)&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('cont');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>País&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('pais');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Télefono&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('telf');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Dirección&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('dire');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Estado&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('estadon');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datprv in filtered = (listprv | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimitprv | limitTo:entryLimitprv">
              <td>{{datprv.num}}</td>
              <td>{{datprv.name}}</td>
              <td>{{datprv.nit}}</td>
              <td>{{datprv.cont}}</td>
              <td>{{datprv.pais}}</td>
              <td>{{datprv.telf}} {{datprv.celu}}</td>
              <td>{{datprv.dire}}</td>
              <td class="text-center"><span class="label {{datprv.estilo}}">{{datprv.estadon}}</span></td>
              <td class="text-center">
                <a href="" ng-click="editProv(datprv.idprv,datprv.name,datprv.nit,datprv.cont,datprv.pais,datprv.telf,datprv.celu,datprv.dire,datprv.fechai,datprv.estado)" class="btn btn-info btn-xs edit" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="" ng-click="deleteProv(datprv.idprv)" class="btn btn-danger btn-xs delete" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimitprv" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/ng-template" id="modalProv">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelprv()"><span aria-hidden="true">&times;</span></button>
          <strong class="text-info"><i>DATOS PROVEEDOR</i></strong>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="paname" class="col-lg-2 control-label">Razon Social</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prov.paname" id="paname" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="panit" class="col-lg-2 control-label">NIT</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prov.panit" id="panit" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="pacont" class="col-lg-2 control-label">Contacto(s)</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prov.pacont" id="pacont" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="papais" class="col-lg-2 control-label">País</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prov.papais" id="papais" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="pafechi" class="col-lg-2 control-label">Fecha registro</label>
              <div class="col-lg-10">
                <div class="input-group">
                  <input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="prov.pafechi" id="pafechi" required="required" current-text="Hoy" toggle-weeks-text="Semana" close-text="Cerrar" clear-text="Borrar" data-show-weeks="false"/>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="patelf" class="col-lg-2 control-label">Télefono</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" ng-model="prov.patelf" id="patelf" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="pacelu" class="col-lg-2 control-label">Celular</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" ng-model="prov.pacelu" id="pacelu" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="padir" class="col-lg-2 control-label">Dirección</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prov.padir" id="padir" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="paest" class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-10">
                <select ng-model="prov.paest" id="paest" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">No activo</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" name="updateProv" ng-click="updateProv(prov)"><i>Actualizar</i></button>
          <button class="btn btn-warning btn-flat" ng-click="cancelprv()"><i>Cancelar</i></button>
        </div>
      </div>
    </script>
    <div ng-show="alertprovs">
      <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
    </div>
    <div ng-show="alertprove">
      <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
    </div>
  </div>
</div>