<div class="row">
  <div class="text-navy text-center"><h4>LISTA DE SERVICIOS</h4></div>
  <div class="col-md-12">
    <div class="table-info">
      <div class="row">
        <div class="col-md-4 col-sm-3">
          <div class="form-group">
            <form name="formlser" action="../pdf/servicios.php" method="POST" target="_blank">
              <p class="text-primary">Exportar: <button ng-click="prn_servicios()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/pdf.png" width="20px" height="20px" title="PDF"></button></p>
              <input type="hidden" name="rdesc">
              <input type="hidden" name="rfech">
              <input type="hidden" name="rcost">
              <input type="hidden" name="robse">
              <input type="hidden" name="resta">
              <input type="hidden" name="rcateg">
            </form>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="form-group">
            <select ng-model="entryLimitser" class="form-control" ng-options="option.value as option.nombre for option in limites">
            </select>
          </div>
        </div>
        <div class="col-md-5 col-sm-5">
          <div class="form-group">
            <input type="text" ng-model="search" ng-change="filter()" placeholder="Buscar..." class="form-control" ng-disabled="actsearch"/>
          </div>
        </div>
      </div>
      <div class="form-group">
        <select ng-model="catserv" ng-change="selectCateg(catserv)" id="catserv" ng-options="option.value as option.name for option in categs" class="form-control">
          <option value="" style="color: red;">Seleccione categoria</option>
        </select>
      </div>
      <div class="table-responsive" id="datalser" ng-show="filteredItems > 0">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
          <thead class="bg-light-blue">
            <tr>
              <th>N&nbsp;°</th>
              <th>Descripción&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('desc');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Fecha&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('fech');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Costo&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('cost');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Observación&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('obse');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th><center>Estado&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('esta');"><i class="glyphicon glyphicon-sort"></i></a></center></th>
              <th><center>Acciones</center></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datser in filtered = (listser | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimitser | limitTo:entryLimitser">
              <td>{{datser.num}}</td>
              <td>{{datser.desc}}</td>
              <td>{{datser.fech}}</td>
              <td>{{datser.cost}}</td>              
              <td>{{datser.obse}}</td>
              <td class="text-center"><span class="label {{datser.estilo}}">{{datser.estan}}</span></td>
              <td class="text-center">
                <a href="" ng-click="editServ(datser.iser,datser.desc,datser.icat,datser.fech,datser.cost,datser.obse,datser.esta)" class="btn btn-info btn-xs edit" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="" ng-click="deleteServ(datser.iser)" class="btn btn-danger btn-xs delete" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimitser" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/ng-template" id="modalServ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelser()"><span aria-hidden="true">&times;</span></button>
          <strong class="text-info"><i>DATOS SERVICIO</i></strong>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="desser" class="col-lg-2 control-label">Descripción</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="serv.desser" id="desser" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="catser" class="col-lg-2 control-label">Categoria</label>
              <div class="col-lg-10">
                <select ng-model="serv.catser" id="catser" ng-options="option.value as option.name for option in categs" class="form-control">
                  <option value="" style="color: red;">Seleccione categoria</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="fechser" class="col-lg-2 control-label">Fecha registro</label>
              <div class="col-lg-10">
                <div class="input-group">
                  <input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="serv.fechser" id="fechser" required="required" current-text="Hoy" toggle-weeks-text="Semana" close-text="Cerrar" clear-text="Borrar" data-show-weeks="false"/>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="cosser" class="col-lg-2 control-label">Costo</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="serv.cosser" id="cosser" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="obsser" class="col-lg-2 control-label">Observación</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="serv.obsser" id="obsser" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="estser" class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-10">
                <select ng-model="serv.estser" id="estser" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">No activo</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" ng-click="updateServ(serv)"><i>Actualizar</i></button>
          <button class="btn btn-warning btn-flat" ng-click="cancelser()"><i>Cancelar</i></button>
        </div>
      </div>
    </script>
    <div ng-show="alertprods">
      <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
    </div>
    <div ng-show="alertprode">
      <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
    </div>
  </div>
</div>