<div class="row">
  <div class="text-navy text-center"><h4>VENDER PRODUCTO</h4></div>
  <div class="col col-md-12">
    <ul class="nav nav-tabs">
      <li class="active"><a href="d#opu" data-toggle="tab"><small class="glyphicon glyphicon-gift"></small> Productos</a></li>
      <li><a href="d#opd" data-toggle="tab"><small class="glyphicon glyphicon-shopping-cart"></small> Carro de ventas <span class="badge">{{cantipo}}</span></a></li>
      <li ng-show="activnotif"><a href="javascript:;" data-toggle="tab"><span class="label label-warning">{{contnotif}}</span></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="opu" style="margin-top: 8px;">
        <div class="row">
          <div class="col col-lg-12">
            <ul class="products-list product-list-in-box">
              <li class="item" ng-repeat="datpro in listprod">
                <div class="col-md-8">
                  <div class="product-img">
                    <img ng-src="../public/img/prods/{{datpro.fotpro}}">
                  </div>
                  <div class="product-info">
                    <a href="javascript::;" class="product-title">{{datpro.nompro}} <span class="label label-info pull-right"><i>{{datpro.prepro}} Bs</i></span></a>
                    <span class="product-description">
                      Proveedor: {{datpro.nomprv}}
                    </span>
                    <span class="product-description">
                      {{datpro.despro}}
                    </span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="cantp">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1" style="width: 95px; background: #F1F5F8;">Disponible</span>
                      <strong type="text" class="form-control bg-white" style="width: 70px; background: #F0F5F8;" aria-describedby="basic-addon1">{{datpro.canpro}} &nbsp;</strong>
                    </div>
                    <div class="input-group text-center">
                      <span class="input-group-addon" id="basic-addon1" style="width: 95px;">Cantidad&nbsp;&nbsp;</span>
                      <input type="number" class="form-control text-center" ng-model="datpro.cantin" ng-disabled="datpro.activo" style="width: 71px;" aria-describedby="basic-addon1">
                    </div>
                  </div>
                  <div class="joinp text-center">
                    <button class="btn btn-flat btn-success" ng-click="agregarProd(datpro.ipro, datpro.cantin, datpro.canpro)" ng-disabled="datpro.activo" id="btnadd"><i class="glyphicon glyphicon-random"></i>&nbsp; Agregar</button>
                  </div>
                </div>
              </li>
            </ul>
          </div>

        </div>
      </div>
      <div class="tab-pane" id="opd" style="margin-top: 8px;">
        <div class="row">
          <form class="form-horizontal" role="form" ng-submit="addpv.sendVenta()">
            <div class="col-md-6">
              <select ng-model="addpv.invpr.icli" id="icli" class="form-control" ng-options="option.codec as option.namec for option in clientes">
                <option value="" style="color: red;">Seleccionar cliente</option>
              </select>
            </div>
            <div class="col-md-3">
              <select ng-model="addpv.invpr.cbank" id="cbank" class="form-control">
                <option value="" style="color: red;">Seleccione cuenta bancaria</option>
                <option value="1">Banco Nacional de Bolivia</option>
                <option value="2">Otro Banco</option>
              </select>
            </div>
            <div class="col-md-3">
              <button ng-disabled="actbtnven" class="btn btn-block btn-flat btn-primary">Realizar venta</button>
            </div>
          </form>
        </div>
        <div class="table-responsive" id="datalcat">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
            <thead class="bg-light-blue">
              <tr>
                <th>Nro</th>
                <th>Producto&nbsp;&nbsp;</th>
                <th><center>Precio&nbsp;&nbsp;</center></th>
                <th><center>Cantidad&nbsp;&nbsp;</center></th>
                <th><center>Subtotal&nbsp;&nbsp;</center></th>
                <th><center>Acciones</center></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="proven in listvent">
                <td>{{proven.num}}</td>
                <td>{{proven.prod}}</td>
                <td><center>{{proven.prec}}</center></td>
                <td><center>{{proven.cantv}}</center></td>
                <td><center>{{proven.subto}}</center></td>
                <td class="text-center">
                  <button ng-click="editTVent(proven.ipro, proven.cantv)" class="btn btn-info btn-xs edit" ng-disabled="btnupd"><i class="glyphicon glyphicon-minus"></i></button>
                  <button ng-click="deleteTVent(proven.ipro, proven.cantv)" class="btn btn-danger btn-xs delete" ng-disabled="btndel"><i class="glyphicon glyphicon-trash"></i></button>
                </td>
              </tr>
              <tr ng-show="mostrarvacio">
                <td colspan="6"><center>CARRITO DE VENTAS VACIO</center></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- </div> -->
  </div>  
</div>
<div ng-show="alertcats">
  <div class="text-center" ng-class="'alert alert-success'">{{messages}}</div>
</div>
<div ng-show="alertcate">
  <div class="text-center" ng-class="'alert alert-danger'">{{messages}}</div>
</div>
<div class="modal fade" id="ventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<script type="text/ng-template" id="modalVent">
  <div class="modal-header text-center">
    <strong class="text-info">CONFIRMACIÓN</strong>
  </div>
  <form name="ivent" action="../pdf/factura.php" method="POST" target="_blank">
    <div class="modal-body text-center">
      <span>Seguro de realizar la venta?</span>
      <p>No se podra revertir la venta, por que se asignará un número de serie</p>
      <label>Forma de pago</label>
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="formu" id="formu"></div>
        <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="detau" id="detau"></textarea></div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="formd" id="formd"></div>
        <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="detad" id="detad"></textarea></div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="formt" id="formt"></div>
        <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="detat" id="detat"></textarea></div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" min="0" max="100" class="form-control input-lg" ng-model="formc" id="formc"></div>
        <div class="col-lg-9"><textarea rows="2" class="form-control" ng-model="detac" id="detac"></textarea></div>
      </div><br>
      <div class="form-group">
        <label for="tiempoe">Tiempo de entrega </label>
          <input type="text" class="form-control text-center" ng-model="tiempoe" id="tiempoe" placeholder="24 hrs, 1 día, ..." required="required">
      </div>
      <div class="form-group">
        <label for="descue">Descuento (%) </label>
          <input type="text" class="form-control text-center" ng-model="descue" id="descue" placeholder="0, 1, 2, ..." required="required">
      </div>
      <div class="form-group">
        <label for="valid">Validez de la oferta</label>
        <select class="form-control text-center" ng-model="valid" id="valid" required="required">
          <option value="15">15 días</option>
          <option value="30">30 días</option>
          <option value="60">60 días</option>
          <option value="90">90 días</option>
        </select>
      </div><br>
    </div>
    <div class="modal-footer text-center">
        <input type="submit" class="btn btn-flat btn-success" ng-click="prnVenta()" value="SI, Imprimir formulario">
        <input type="hidden" name="rcli">
        <input type="hidden" name="rmod">
        <input type="button" class="btn btn-flat btn-warning" ng-click="cancelven()" value="NO, Cancelar">   
    </div>
  </form>
</script>