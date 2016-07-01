<div class="row">
  <div class="text-navy text-center"><h4>LISTA DE CLIENTES</h4></div>
  <div class="col-md-12">
    <div class="table-info">
      <div class="row">
        <div class="col-md-4 col-sm-3">
          <div class="form-group">
            <form name="formlcli" action="../pdf/clientes.php" method="POST" target="_blank">
              <p class="text-primary">Exportar: <button ng-click="prn_clientes()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/pdf.png" width="20px" height="20px" title="PDF"></button></p>
              <input type="hidden" name="rnomb">
              <input type="hidden" name="rnitc">
              <input type="hidden" name="rtelf">
              <input type="hidden" name="rcorr">
              <input type="hidden" name="rtipo">
              <input type="hidden" name="rfech">
              <input type="hidden" name="rciud">
              <input type="hidden" name="rdire">
              <input type="hidden" name="resta">
            </form>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="form-group">
            <select ng-model="entryLimitcli" class="form-control" ng-options="option.value as option.nombre for option in limites">
            </select>
          </div>
        </div>
        <div class="col-md-5 col-sm-5">
          <div class="form-group">
            <input type="text" ng-model="search" ng-change="filter()" placeholder="Buscar..." class="form-control"/>
          </div>
        </div>
      </div>
      <div class="table-responsive" id="datalcli" ng-show="filteredItems > 0">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
          <thead class="bg-light-blue">
            <tr>
              <th>N&nbsp;°</th>
              <th>Nombre&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('clie');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>CI&nbsp;/&nbsp;NIT&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('nit');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Teléfono&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('telf');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Correo&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('mail');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Tipo&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('tipon');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Fecha&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('fech');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Ciudad&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('ciud');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Dirección&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('dire');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th><center>Estado&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('esta');"><i class="glyphicon glyphicon-sort"></i></a></center></th>
              <th><center>Acciones</center></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datcli in filtered = (listcli | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimitcli | limitTo:entryLimitcli">
              <td>{{datcli.num}}</td>
              <td>{{datcli.clie}}</td>
              <td>{{datcli.nit}}</td>
              <td>{{datcli.telf}}</td>
              <td>{{datcli.mail}}</td>              
              <td>{{datcli.tipon}}</td>
              <td>{{datcli.fech}}</td>
              <td>{{datcli.ciudn}}</td>
              <td>{{datcli.dire}}</td>
              <td class="text-center"><span class="label {{datcli.estilo}}">{{datcli.estan}}</span></td>
              <td class="text-center">
                <a href="" ng-click="editClie(datcli.icli,datcli.clie,datcli.nit,datcli.telf,datcli.celu,datcli.mail,datcli.tipo,datcli.fech,datcli.ciud,datcli.dire,datcli.esta)" class="btn btn-info btn-xs edit" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="" ng-click="deleteClie(datcli.icli)" class="btn btn-danger btn-xs delete" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimitcli" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/ng-template" id="modalClie">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelcli()"><span aria-hidden="true">&times;</span></button>
          <strong class="text-info"><i>DATOS CLIENTE</i></strong>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="nomcli" class="col-lg-2 control-label">Nombre</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="clie.nomcli" id="nomcli" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="nitcli" class="col-lg-2 control-label">CI/NIT</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="clie.nitcli" id="nitcli" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="telcli" class="col-lg-2 control-label">Teléfono</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" ng-model="clie.telcli" id="telcli" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="celcli" class="col-lg-2 control-label">Celular</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" ng-model="clie.celcli" id="celcli" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="corcli" class="col-lg-2 control-label">Correo</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="clie.corcli" id="corcli">
              </div>
            </div>
            <div class="form-group">
              <label for="tipcli" class="col-lg-2 control-label">Tipo</label>
              <div class="col-lg-10">
                <select ng-model="clie.tipcli" id="tipcli" class="form-control">
                  <option value="1">Empresa</option>
                  <option value="0">Persona</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="fechcli" class="col-lg-2 control-label">Fecha</label>
              <div class="col-lg-10">
                <div class="input-group">
                  <input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="clie.fechcli" id="fechcli" required="required" current-text="Hoy" toggle-weeks-text="Semana" close-text="Cerrar" clear-text="Borrar" data-show-weeks="false" placeholder="*"/>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="ciucli" class="col-lg-2 control-label">Ciudad</label>
              <div class="col-lg-10">
                <select ng-model="clie.ciucli" id="ciucli" ng-options="option.value as option.name for option in procity" class="form-control">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="dircli" class="col-lg-2 control-label">Dirección</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="clie.dircli" id="dircli">
              </div>
            </div>
            <div class="form-group">
              <label for="estcli" class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-10">
                <select ng-model="clie.estcli" id="estcli" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">No activo</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" ng-click="updateClie(clie)"><i>Actualizar</i></button>
          <button class="btn btn-warning btn-flat" ng-click="cancelcli()"><i>Cancelar</i></button>
        </div>
      </div>
    </script>
    <div ng-show="alertclis">
      <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
    </div>
    <div ng-show="alertclie">
      <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
    </div>
  </div>
</div>