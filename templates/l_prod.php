<div class="row">
  <div class="text-navy text-center"><h4>LISTA DE PRODUCTOS</h4></div>
  <div class="col-md-12">
    <div class="table-info">
      <div class="row">
        <div class="col-md-4 col-sm-3">
          <div class="form-group">
            <form name="formlpro" action="../pdf/productos.php" method="POST" target="_blank">
              <p class="text-primary">Exportar: <button ng-click="prn_productos()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/pdf.png" width="20px" height="20px" title="PDF"></button></p>
              <input type="hidden" name="rnomb">
              <input type="hidden" name="rprov">
              <input type="hidden" name="rfech">
              <input type="hidden" name="rcant">
              <input type="hidden" name="rprec">
              <input type="hidden" name="rdesc">
              <input type="hidden" name="resta">
            </form>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="form-group">
            <select ng-model="entryLimitpro" class="form-control" ng-options="option.value as option.nombre for option in limites">
            </select>
          </div>
        </div>
        <div class="col-md-5 col-sm-5">
          <div class="form-group">
            <input type="text" ng-model="search" ng-change="filter()" placeholder="Buscar..." class="form-control" />
          </div>
        </div>
      </div>
      <div class="table-responsive" id="datalpro" ng-show="filteredItems > 0">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
          <thead class="bg-light-blue">
            <tr>
              <th>N&nbsp;°</th>
              <th>Nombre&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('nomb');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Proveedor&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('nprv');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Cantidad&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('cant');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Precio&nbsp;(u)&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('proc');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Fecha&nbsp;registro&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('fechai');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th>Descripción&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('desc');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th><center>Estado&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('esta');"><i class="glyphicon glyphicon-sort"></i></a></center></th>
              <th><center>Acciones</center></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datpro in filtered = (listpro | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimitpro | limitTo:entryLimitpro">
              <td>{{datpro.num}}</td>
              <td>{{datpro.nomb}}</td>
              <td>{{datpro.nprv}}</td>
              <td>{{datpro.cant}}</td>
              <td>{{datpro.proc}}</td>              
              <td>{{datpro.fech}}</td>
              <td>{{datpro.desc}}</td>
              <td class="text-center"><span class="label {{datpro.estilo}}">{{datpro.estan}}</span></td>
              <td class="text-center">
                <a href="" ng-click="editProd(datpro.ipro,datpro.iprv,datpro.nomb,datpro.desc,datpro.cant,datpro.proc,datpro.fech,datpro.foto,datpro.esta)" class="btn btn-info btn-xs edit" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="" ng-click="deleteProd(datpro.ipro,datpro.foto)" class="btn btn-danger btn-xs delete" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
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
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimitpro" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/ng-template" id="modalProd">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelpro()"><span aria-hidden="true">&times;</span></button>
          <strong class="text-info"><i>DATOS PRODUCTO</i></strong>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" class="form-horizontal formp" role="form">
            <div class="form-group">
              <label for="pnomb" class="col-lg-2 control-label">Nombre</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prod.pnomb" id="pnomb" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="iprv" class="col-lg-2 control-label">Proveedor</label>
              <div class="col-lg-10">
                <select ng-model="prod.iprv" id="iprv" ng-options="option.value as option.name for option in listprov" class="form-control">
                  <option value="" style="color: red;">Seleccione proveedor</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="pfech" class="col-lg-2 control-label">Fecha registro</label>
              <div class="col-lg-10">
                <div class="input-group">
                  <input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="prod.pfech" id="pfech" required="required" current-text="Hoy" toggle-weeks-text="Semana" close-text="Cerrar" clear-text="Borrar" data-show-weeks="false"/>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="pcant" class="col-lg-2 control-label">Cantidad</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" ng-model="prod.pcant" id="pcant" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="pprec" class="col-lg-2 control-label">Precio&nbsp;(u)</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prod.pprec" id="pprec" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="pdesc" class="col-lg-2 control-label">Descripción</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" ng-model="prod.pdesc" id="pdesc" required="required">
              </div>
            </div>
            <div class="form-group text-center">
              <div id="nombreimg" style="display: none;">{{nombreimg}}</div>
              <input type="hidden" name="nimg" id="nimg">
              <div id="nombreimgn" style="display: none;"></div>
              <img id="imgloadp" ng-src="{{mostrarimg}}" width="100px" height="100px"><br>
              <center><input type="file" name="updfot" id="updfot" onchange="changeImgp()" class="btn btn-default btn-sm"></center>
            </div>
            <div class="form-group">
              <label for="pesta" class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-10">
                <select ng-model="prod.pesta" id="pesta" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">No activo</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <code>{{nota}}&nbsp;</code>
          <button class="btn btn-primary btn-flat" ng-click="updateProd(prod)"><i>Actualizar</i></button>
          <button class="btn btn-warning btn-flat" ng-click="cancelpro()"><i>Cancelar</i></button>
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