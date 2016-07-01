<div class="row">
  <div class="text-navy text-center"><h4>LISTA DE USUARIOS</h4></div>
  <div class="col-md-12">
    <div class="table-info">
      <div class="row">
        <!-- <div class="col-md-4 col-sm-3">
          <div class="form-group">
            <form name="formlprv" action="../pdf/proveedores.php" method="POST" target="_blank">
              <p class="text-primary">Exportar: <button ng-click="prn_proveedor()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/pdf.png" width="20px" height="20px" title="PDF"></button></p>
              <input type="hidden" name="rnomb">
              <input type="hidden" name="rcedu">
              <input type="hidden" name="rtefl">
              <input type="hidden" name="rdire">
              <input type="hidden" name="resta">
            </form>
          </div>
        </div> -->
        <div class="col-md-3 col-sm-4 col-md-offset-4 col-sm-offset-3">
          <div class="form-group">
            <select ng-model="entryLimituse" class="form-control" ng-options="option.value as option.nombre for option in limites">
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
              <th>N&nbsp;°&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('num');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Nombre&nbsp;completo&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('nomb');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Cédula&nbsp;identidad&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('dni');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Fecha&nbsp;registro&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('fech');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Télefono&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('telf');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Dirección&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('dire');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Estado&nbsp;&nbsp;<a class="btnsort text-aqua" ng-click="sort_by('estn');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datus in filtered = (listuse | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimituse | limitTo:entryLimituse">
              <td>{{datus.num}}</td>
              <td>{{datus.nomb}}</td>
              <td>{{datus.dni}} {{datus.procn}}</td>
              <td>{{datus.fech}}</td>
              <td>{{datus.telf}}</td>
              <td>{{datus.dire}}</td>
              <td class="text-center"><span class="label {{datus.esti}}">{{datus.estn}}</span></td>
              <td class="text-center">
                <a href="" ng-click="editUser(datus.ius,datus.use,datus.nomb,datus.dni,datus.proc,datus.carg,datus.telf,datus.corr,datus.dire,datus.est)" class="btn btn-info btn-xs edit" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="" ng-click="deleteUser(datus.ius)" class="btn btn-danger btn-xs delete" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimituse" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/ng-template" id="modalUser">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="canceluse()"><span aria-hidden="true">&times;</span></button>
          <strong class="text-info"><i>DATOS USUARIO</i></strong>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="uusu" class="col-lg-2 control-label">Usuario</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="use.uusu" id="uusu" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="unom" class="col-lg-2 control-label">Nombre</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="use.unom" id="unom" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="udni" class="col-lg-2 control-label">Cédula</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" ng-model="use.udni" id="udni" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="upro" class="col-lg-2 control-label">Procedencia</label>
              <div class="col-lg-10">
                <select ng-model="use.upro" id="upro" ng-options="option.value as option.name for option in procity" class="form-control">
                  <option value="" style="color: red;">Seleccione procedencia</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="ucar" class="col-lg-2 control-label">Cargo</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="use.ucar" id="ucar" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="utel" class="col-lg-2 control-label">Télefono</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" ng-model="use.utel" id="utel" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="ucor" class="col-lg-2 control-label">Correo</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" ng-model="use.ucor" id="ucor" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="udir" class="col-lg-2 control-label">Dirección</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="use.udir" id="udir" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="ucla" class="col-lg-2 control-label">Cambiar clave</label>
              <div class="col-lg-10">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><input type="checkbox" ng-model="inpc" ng-change="actinp(inpc)"></span>
                  <input type="text" ng-model="use.ucla" id="ucla" class="form-control" placeholder="Cambiar clave" aria-describedby="basic-addon1" disabled="true">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="uest" class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-10">
                <select ng-model="use.uest" id="uest" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">No activo</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" ng-click="updateUser(use)"><i>Actualizar</i></button>
          <button class="btn btn-warning btn-flat" ng-click="canceluse()"><i>Cancelar</i></button>
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