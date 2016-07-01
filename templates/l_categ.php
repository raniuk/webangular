<div class="row">
  <div class="text-navy text-center"><h4>LISTA DE CATEGORIAS</h4></div>
  <div class="col-md-12">
    <div class="table-info">
      <div class="row">
        <div class="col-md-4 col-sm-3">
          <div class="form-group">
            <form name="formlcat" action="../pdf/categorias.php" method="POST" target="_blank">
              <p class="text-primary">Exportar: <button ng-click="prn_categorias()" style="background: transparent; border: 0px; outline: none;" ng-disabled="actpdf"><img src="../public/img/pdf.png" width="20px" height="20px" title="PDF"></button></p>
              <input type="hidden" name="rdesc">
              <input type="hidden" name="resta">
            </form>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="form-group">
            <select ng-model="entryLimitcat" class="form-control" ng-options="option.value as option.nombre for option in limites">
            </select>
          </div>
        </div>
        <div class="col-md-5 col-sm-5">
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
              <th>Descripción&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('descat');"><i class="glyphicon glyphicon-sort"></i></a></th>
              <th><center>Estado&nbsp;&nbsp;<a class="btnsort" ng-click="sort_by('esta');"><i class="glyphicon glyphicon-sort"></i></a></center></th>
              <th><center>Acciones</center></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datpro in filtered = (listcat | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimitcat | limitTo:entryLimitcat">
              <td>{{datpro.num}}</td>
              <td>{{datpro.descat}}</td>
              <td class="text-center"><span class="label {{datpro.estilocat}}">{{datpro.estadoncat}}</span></td>
              <td class="text-center">
                <button ng-click="editCateg(datpro.icat,datpro.descat,datpro.estadocat)" class="btn btn-info btn-xs edit" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
                <button ng-click="deleteCateg(datpro.icat)" class="btn btn-danger btn-xs delete" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
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
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimitcat" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/ng-template" id="modalCatpy">
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" ng-click="updateCatpy(cproy)"><span>Actualizar</span></button>
        <button class="btn btn-warning" ng-click="cancelcpy()"><span>Cancelar</span></button>
      </div>
    </script>
    <script type="text/ng-template" id="modalCat">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancelcat()"><span aria-hidden="true">&times;</span></button>
          <strong class="text-info"><i>DATOS CATEGORIA</i></strong>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="descat" class="col-lg-2 control-label">Descripción</label>
              <div class="col-lg-10">
                <textarea rows="3" class="form-control" ng-model="cats.descat" id="descat" required="true"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="estcat" class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-10">
                <select ng-model="cats.estcat" id="estcat" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">No activo</option>
                </select>
              </div>
            </div>          
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" ng-click="updateCateg(cats)"><i>Actualizar</i></button>
          <button class="btn btn-warning btn-flat" ng-click="cancelcat()"><i>Cancelar</i></button>
        </div>
      </div>
    </script>
    <div ng-show="alertcats">
      <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
    </div>
    <div ng-show="alertcate">
      <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
    </div>
  </div>
</div>