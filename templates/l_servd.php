<div class="row">
  <div class="text-navy text-center"><h4>LISTA DE SERVICIO DIARIA</h4></div>
  <div class="col-md-12">
    <div class="table-info">
      <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <form name="formlsd" action="../pdf/excelsdiaria.php" method="POST" target="_blank">
              <p class="text-primary">Exportar:&nbsp;<button ng-click="prn_servd()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/excel.png" width="20px" height="20px" title="Excel"></button></p>
              <input type="hidden" name="rfecha">
            </form>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="fechas" id="fechas" ng-change="resetServ(fechas)" placeholder=" <?php echo date("Y-m-d"); ?>" required="required" current-text="Hoy" toggle-weeks-text="Semana" close-text="Cerrar" clear-text="Borrar" data-show-weeks="false"/>
              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-2">
            <select ng-model="entryLimitps" class="form-control" ng-options="option.value as option.nombre for option in limites">
            </select>
        </div>
        <div class="col-md-5">
            <input type="text" ng-model="search" ng-change="filter()" placeholder="Buscar..." class="form-control" />
        </div>
      </div>
      <div class="table-responsive" id="datalprv" ng-show="filteredItems > 0">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
          <thead class="bg-light-blue">
            <tr>
              <th>N&nbsp;°&nbsp;&nbsp;<a class="btnsort  text-aqua" ng-click="sort_by('num');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Nombre&nbsp;cliente&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('nomc');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Empresa&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('razon');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Forma&nbsp;pago&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('forms');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Tiempo&nbsp;entrega&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('dni');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datps in filtered = (listspro | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimitps | limitTo:entryLimitps">
              <td>{{datps.num}}</td>
              <td>{{datps.nomc}}</td>
              <td>{{datps.razon}}</td>
              <td class="text-center"><span class="label {{datps.stilo}}">{{datps.forms}} %</span></td>
              <td>{{datps.tiempo}}</td>
              <td class="text-center">
                <button ng-click="factServ(datps.ipse,datps.iserv,datps.icli)" title="Ver formulario" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt"></i></button>
                <button ng-disabled="{{datps.actbtn}}" ng-click="editServ(datps.ipse,datps.formpu,datps.detalu,datps.formpd,datps.detald,datps.formpt,datps.detalt,datps.formpc,datps.detalc)" title="Actualizar forma pago" class="btn btn-info btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                <button ng-click="deleteServ(datps.ipse)" title="Eliminar servicio" class="btn btn-danger btn-xs delete"><i class="glyphicon glyphicon-trash"></i></button>
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
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimitps" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/ng-template" id="modalServ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelus()"><span aria-hidden="true">&times;</span></button>
          <strong class="text-info"><i>DATOS SERVICIO</i></strong>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">            
            <center><label>Forma de pago</label></center>
            <div class="form-group">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control input-lg" ng-model="user.formu" ></div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <textarea rows="2" ng-model="user.detau" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control input-lg" ng-model="user.formd" ></div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <textarea rows="2" ng-model="user.detad" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control input-lg" ng-model="user.formt" ></div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <textarea rows="2" ng-model="user.detat" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control input-lg" ng-model="user.formc" ></div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <textarea rows="2" ng-model="user.detac" class="form-control"></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" ng-click="updateServ(user)"><i>Actualizar</i></button>
          <button class="btn btn-warning btn-flat" ng-click="cancelus()"><i>Cancelar</i></button>
        </div>
      </div>
    </script>
    <div ng-show="alertpsers">
      <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
    </div>
    <div ng-show="alertpsere">
      <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
    </div>
  </div>
</div>
<div class="modal fade" id="factModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-alert"></span> CONFIRMACIÓN</h4>
      </div>
      <form name="fvent" action="../pdf/sdfactura.php" method="POST" target="_blank">
        <div class="modal-body text-center">
          <h5>Desea ver el formulario en PDF?</h5>
        </div>
        <div class="modal-footer text-center">
          <button class="btn btn-flat btn-success" ng-click="cerrarDialog()"><i>SI, Ver formulario</i></button>
          <input type="hidden" name="rips">
          <input type="hidden" name="rcli">
          <input type="hidden" name="rservs">
          <button class="btn btn-flat btn-warning" data-dismiss="modal"><i>NO, Cancelar</i></button>
        </div>
      </form>
    </div>
  </div>
</div>