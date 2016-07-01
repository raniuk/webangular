'use strict';
var app = angular.module('gmzbol', ['ui.router', 'ngAnimate', 'anim-in-out','ui.bootstrap']);
app.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
  //$locationProvider.html5Mode(true).hashPrefix('!');
  $urlRouterProvider
    .otherwise('ini');
  $stateProvider
    .state('ini', {
      url: '/ini',
      views: {
        "vmain": {
          title: 'Venta',
          templateUrl: '../templates/navso.php',
          controller: 'aprinCtrl'
        }
      }
    })
    .state('vpr', {
      url: '/rpv',
      views: {
        "vmain": {
          title: 'Ventas',
          templateUrl: '../templates/a_vent.php',
          controller: 'a_ventCtrl',
          controllerAs: 'addpv'
        }
      }
    })
    .state('ldv', {
      url: '/ldv',
      views: {
        "vmain": {
          title: 'Ventas',
          templateUrl: '../templates/l_vend.php',
          controller: 'l_vendCtrl'
        }
      }
    })
    .state('lmv', {
      url: '/lmv',
      views: {
        "vmain": {
          title: 'Ventas',
          templateUrl: '../templates/l_venm.php',
          controller: 'l_venmCtrl'
        }
      }
    })
    .state('lav', {
      url: '/lav',
      views: {
        "vmain": {
          title: 'Ventas',
          templateUrl: '../templates/l_vena.php',
          controller: 'l_venaCtrl'
         }
      }
    })
    .state('pss', {
      url: '/pss',
      views: {
        "vmain": {
          title: 'Servicios',
          templateUrl: '../templates/p_serv.php',
          controller: 'p_servCtrl',
          controllerAs: 'addps'
        }
      }
    })
    .state('lds', {
      url: '/lds',
      views: {
        "vmain": {
          title: 'Servicios',
          templateUrl: '../templates/l_servd.php',
          controller: 'l_servdCtrl'
        }
      }
    })
    .state('lms', {
      url: '/lms',
      views: {
        "vmain": {
          title: 'Servicios',
          templateUrl: '../templates/l_servm.php',
          controller: 'l_servmCtrl'
        }
      }
    })
    .state('las', {
      url: '/las',
      views: {
        "vmain": {
          title: 'Servicios',
          templateUrl: '../templates/l_serva.php',
          controller: 'l_servaCtrl'
        }
      }
    })
    .state('rct', {
      url: '/rct',
      views: {
        "vmain": {
          title: 'Clientes',
          templateUrl: '../templates/a_clie.php',
          controller: 'a_clienCtrl',
          controllerAs: 'addrl'
        }
      }
    })
  }]);
app.filter('startFrom', function() {
  return function(input, start) {
    if(input) {
      start = +start;
      return input.slice(start);
    }
    return [];
  }
});
app.controller('aprinCtrl', function ($scope, $http) {
  //$rootScope.pnav = "sasa";
});
app.controller('a_clienCtrl', function ($scope, $http, $timeout) {
  $timeout(function(){
    getLocation($http, $scope);
  },100);
  var cli = this;
  cli.incli = {};
  $scope.actrs = true;
  $scope.funcTipo = function (tipo) {
    if (tipo==1) {
      $scope.actrs = false;
      cli.incli.clirazs = "";
    }else{
      $scope.actrs = true;
      cli.incli.clirazs = "---";
    }
  }
  cli.sendClie = function () {
    if(cli.incli.clitipo==undefined){
      $("#clieModal").modal('show');
      $scope.notificacion = "Seleccione tipo cliente !!!";
    } else{
      if(cli.incli.clirazs==""){
        $("#clieModal").modal('show');
        $scope.notificacion = "Ingrese nombre de la empresa o razon social !!!";
      }
      else{
        if(cli.incli.cliciu==undefined){
          $("#clieModal").modal('show');
          $scope.notificacion = "Seleccione ciudad !!!";
        }else{
          $http.post('../back/clien.php?action=add', cli.incli).success(function (data){
            cli.incli = {};
            if (data=="ok") {
              $scope.alertclis = true;
              $scope.messages = "Registro efectuado con éxito !!!";
            }
          })
          .error(function (data){
            cli.incli = {};
            $scope.alertclie = true;
            $scope.messages = "Error al enviar los datos !!! - " + data;
          });
        }
      }
    }
  }
});
function TypeaheadCtrl($scope) {
  $scope.selected = undefined;
  $scope.states = [];
  $scope.onedit = function(){
    $scope.states = [];
    
    for(var i = 0; i < 10; i++){
      var value = "";
      
      for(var j = 0; j < i; j++){
        value += j;
      }
      $scope.states.push(value);
    }
  }
}

app.controller('ConfigTitleCtrl', ['$scope', '$http', '$q', function ($scope, $http, $q) {
        
}]);
app.controller('a_ventCtrl', function ($scope, $http, $timeout, $modal, $document, $state) {
	$http.get('../back/clien.php?action=sear').success(function (clisear){
		$scope.clientes = clisear;
  });
	$scope.cantipo = 0;
	$scope.mostrarvacio = false;
	$scope.actbtnven = true;
	$timeout(loadProds, 100);
	function loadProds() {
		$http.get('../back/prods.php?action=list').success(function (datapro){
			$scope.listprod = datapro;
			$scope.btnactivo = true;
			mostrarVentemp();
	  });
	}
	function loadProdsu() {
		$http.get('../back/prods.php?action=list').success(function (datapro){
			$scope.listprod = datapro;
	  });
	}
  function mostrarVentemp() {
		$http.get('../back/tvents.php?action=get').success(function (datali){			
			if (datali.length>0) {
				$scope.cantipo = datali.length;
				$scope.listvent = datali;
				$scope.mostrarvacio = false;
				$scope.actbtnven = false;
				$scope.btnupd = false;
				$scope.btndel = false;
			}
			else{
				$scope.mostrarvacio = true;
				$scope.actbtnven = true;
			}
	  });
	}
	function mostrarVentempu() {
		$http.get('../back/tvents.php?action=get').success(function (datali){			
			if (datali.length>0) {
				$scope.btnupd = false;
				$scope.btndel = false;
				$scope.cantipo = datali.length;
				$scope.listvent = datali;
				$scope.mostrarvacio = false;
				loadProdsu();
			} else {
				$scope.listvent = datali;
				$scope.cantipo = datali.length;
				$scope.mostrarvacio = true;
				$scope.actbtnven = true;
				loadProdsu();
			}
	  });
	}
  $scope.agregarProd = function(prod, cantidad, cantpro){
  	$("#btnadd").prop("disabled", true);
  	if (cantpro<cantidad || cantidad==0) {
  		$("#ventModal").modal('show');
      $scope.notificacion = "La cantidad seleccionada debe ser menor a la cantidad del producto. ("+cantidad+" < "+cantpro+") y mayor a 0";
  	} else{
  		$http.post('../back/tvents.php?action=add', {ipro:prod, cants:cantidad, cantp:cantpro}).success(function (datav){
        if (datav=="ok") {
        	$("#btnadd").prop("disabled", true);
        	$timeout(loadProds, 500);
        	$scope.contnotif = "PRODUCTO AGREGADO";
          $scope.activnotif = true;
          $timeout( function(){ $scope.activnotif = false; }, 1000);
        } else{
        	$timeout(loadProds, 500);
        	$scope.contnotif = "ERROR";
          $scope.activnotif = true;
          $timeout( function(){ $scope.activnotif = false; }, 1000);
        }
      })
      .error(function(datav){
      	$timeout(loadProds, 500);
      	$scope.contnotif = "ERROR";
      	$scope.activnotif = true;
      	$timeout( function(){ $scope.activnotif = false; }, 1000);
      });
  	}
  }
  $scope.editTVent = function(prod, cantidad){
  	$scope.btnupd = true;
  	$scope.btndel = true;
		$http.post('../back/tvents.php?action=upd', {ipro:prod, cants:cantidad}).success(function (dataup){
      if (dataup=="ok") {
      	$timeout(mostrarVentempu, 200);
      	$scope.contnotif = "CARRITO ACTUALIZADO";
        $scope.activnotif = true;
        $timeout( function(){ $scope.activnotif = false; }, 1000);
      } else{
      	$timeout(mostrarVentempu, 200);
      	$scope.contnotif = "ERROR";
        $scope.activnotif = true;
        $timeout( function(){ $scope.activnotif = false; }, 1000);
      }
    })
    .error(function (dataup){
    	$timeout(mostrarVentempu, 200);
    	$scope.contnotif = "ERROR";
      $scope.activnotif = true;
      $timeout( function(){ $scope.activnotif = false; }, 1000);
    });
  }
  $scope.deleteTVent = function(prod, cantidad){
  	$scope.btnupd = true;
  	$scope.btndel = true;
		$http.post('../back/tvents.php?action=del', {ipro:prod, cants:cantidad}).success(function (dataup){
      if (dataup=="ok") {
      	$timeout(mostrarVentempu, 200);
      }else{
      	$timeout(mostrarVentempu, 200);
      	$scope.contnotif = "ERROR";
      	$scope.activnotif = true;
      	$timeout( function(){ $scope.activnotif = false; }, 1000);
      }
    })
    .error(function (dataup){
    	$timeout(mostrarVentempu, 200);
    	$scope.contnotif = "ERROR";
     	$scope.activnotif = true;
      $timeout( function(){ $scope.activnotif = false; }, 1000);
    });
  }
	var bodyRef = angular.element( $document[0].body );
  var pvt = this;
  pvt.invpr = {};
  pvt.sendVenta = function () {
  	if (pvt.invpr.icli==undefined) {
  		$("#ventModal").modal('show');
      $scope.notificacion = "Seleccione o busque al cliente !!!";
  	} else{
  		if (pvt.invpr.cbank==undefined) {
  			$("#ventModal").modal('show');
      	$scope.notificacion = "Seleccione la cuenta bancaria a utilizar !!!";
  		}else{
			  bodyRef.addClass('ovh');
		    var modalInstance = $modal.open({
		      templateUrl: 'modalVent',
		      controller: ModalInstanceCtrlven,
		      resolve: {
		        datoven: function () {
		          return [pvt.invpr.icli, pvt.invpr.cbank];
		        }
		      }
		    });
		    modalInstance.result.then(function (act) {
		      bodyRef.removeClass('ovh');
		      if (act=="oks") {
		        $state.go('ldv');
		      }
		    }, function () {
		      bodyRef.removeClass('ovh');
		    });

  		}
  	}
  }
});
var ModalInstanceCtrlven = function ($scope, $http, $timeout, $modalInstance, datoven) {
  $scope.descue = 0;
  $scope.formu = 0;
  $scope.detau = "";
  $scope.formd = 0;
  $scope.detad = "";
  $scope.formt = 0;
  $scope.detat = "";
  $scope.formc = 0;
  $scope.detac = "";
  $scope.valid = 15;
  $scope.prnVenta = function() {
  	if ($("input#tiempoe").val()!="") {
  		document.ivent.rcli.value = datoven[0];
	    document.ivent.rmod.value = datoven[1];
	    $http.post('../back/vents.php?action=add', {icli:datoven[0], cbank:datoven[1], foru:$("input#formu").val(), detau:$("textarea#detau").val(), ford:$("input#formd").val(), detad:$("textarea#detad").val(), fort:$("input#formt").val(), detat:$("textarea#detat").val(), forc:$("input#formc").val(), detac:$("textarea#detac").val(), tiempo:$("input#tiempoe").val(), descu:$("input#descue").val(), vali:$("select#valid").val()})
	    .success(function (data, status, headers, config) {
	    	if (data=="ok") {
	    		$modalInstance.close("oks");
	    	}
	    })
	    .error(function (data, status, headers, config){
	      $modalInstance.close("Error al realizar la venta !!!");
	    });
  	}
  };
  $scope.cancelven = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('l_vendCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.fechav = new Date();
  $scope.limites = [{value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}, {value:1000, nombre:"1000"}, {value:10000, nombre:"10000"}, {value:100000, nombre:"100000"}];
  funListVentad($scope.fechav);
  $scope.resetVent = function (fecha) {
    funListVentad(fecha);
  }
  function funListVentad (fecha) {
    $http.post('../back/vents.php?action=getd', {fechas:fecha.toJSON().slice(0,10)}).success(function (datad){
      $scope.listvpro = datad;
      $scope.currentPage = 1;
      $scope.entryLimitvp = 10;
      $scope.filteredItems = $scope.listvpro.length;
      $scope.totalItems = $scope.listvpro.length;
      if ($scope.listvpro.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }
    });
  }
  $scope.setPage = function(pageNo) {
    $scope.currentPage = pageNo;
  };
  $scope.filter = function() {
    $timeout(function() { 
      $scope.filteredItems = $scope.filtered.length;
    }, 10);
  };
  $scope.sort_by = function(predicate) {
    $scope.predicate = predicate;
    $scope.reverse = !$scope.reverse;
  };
  $scope.factVent = function (iven, icli) {
    document.fvent.rcli.value = icli;
    document.fvent.rven.value = iven;
    $("#factModal").modal('show');
  };
  $scope.cerrarDialog = function () {
    $("#factModal").modal('hide');
  }
  var bodyRef = angular.element( $document[0].body );
  $scope.editVent = function (iven,formu,detau,formd,detad,formt,detat,formc,detac) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalVent',
      controller: ModalInstanceCtrluve,
      resolve: {
        datouv: function () {
          return [iven,formu,detau,formd,detad,formt,detat,formc,detac];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      funListVentad($scope.fechav);
      if (act=="oks") {
        $scope.alertprovs = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertprove = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteVent = function (ven) {
    var confir = confirm("Está seguro de eliminar la venta, puede que afecte a la correlación?");
    if(confir) {
      $http.post('../back/vents.php?action=del', {'iven': ven})
      .success(function (data, status, headers, config) {               
        funListVentad($scope.fechav);
        $scope.alertprovs = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertprove = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_ventad = function () {
    document.formlvd.rfecha.value = $scope.fechav.toJSON().slice(0,10);
  }
});
var ModalInstanceCtrluve = function ($scope, $http, $timeout, $modalInstance, datouv) {
  $scope.uven = {iven: "",formu: "",detau: "",formd: "",detad: "",formt: "",detat: "",formc: "",detac: ""};
  $scope.uven.iven = datouv[0];
  $scope.uven.formu = datouv[1]*1;
  $scope.uven.detau = datouv[2];
  $scope.uven.formd = datouv[3]*1;
  $scope.uven.detad = datouv[4];
  $scope.uven.formt = datouv[5]*1;
  $scope.uven.detat = datouv[6];
  $scope.uven.formc = datouv[7]*1;
  $scope.uven.detac = datouv[8];
  $scope.updateVent = function(duven) {
    $http.post('../back/vents.php?action=upd', duven)
    .success(function (data, status, headers, config) {
      $modalInstance.close("oks");
      $scope.uven = {};
    })
    .error(function (data, status, headers, config){
      $scope.uven = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.canceluv = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('l_venmCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.fechav = new Date();
  $scope.limites = [{value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}, {value:1000, nombre:"1000"}, {value:10000, nombre:"10000"}, {value:100000, nombre:"100000"}];
  funListVentam($scope.fechav);
  $scope.resetVent = function (fecha) {
    funListVentam(fecha);
  }
  function funListVentam (fecha) {
    $http.post('../back/vents.php?action=getm', {fechas:fecha.toJSON().slice(0,7)}).success(function (datad){
      $scope.listvpro = datad;
      $scope.currentPage = 1;
      $scope.entryLimitvp = 10;
      $scope.filteredItems = $scope.listvpro.length;
      $scope.totalItems = $scope.listvpro.length;
      if ($scope.listvpro.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }
    });
  }
  $scope.setPage = function(pageNo) {
    $scope.currentPage = pageNo;
  };
  $scope.filter = function() {
    $timeout(function() { 
      $scope.filteredItems = $scope.filtered.length;
    }, 10);
  };
  $scope.sort_by = function(predicate) {
    $scope.predicate = predicate;
    $scope.reverse = !$scope.reverse;
  };
  $scope.factVent = function (iven, icli) {
    document.fvent.rcli.value = icli;
    document.fvent.rven.value = iven;
    $("#factModal").modal('show');
  };
  $scope.cerrarDialog = function () {
    $("#factModal").modal('hide');
  }
  var bodyRef = angular.element( $document[0].body );
  $scope.editVent = function (iven,formu,detau,formd,detad,formt,detat,formc,detac) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalVent',
      controller: ModalInstanceCtrluve,
      resolve: {
        datouv: function () {
          return [iven,formu,detau,formd,detad,formt,detat,formc,detac];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      funListVentam($scope.fechav);
      if (act=="oks") {
        $scope.alertprovs = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertprove = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteVent = function (ven) {
    var confir = confirm("Está seguro de eliminar la venta, puede que afecte a la correlación?");
    if(confir) {
      $http.post('../back/vents.php?action=del', {'iven': ven})
      .success(function (data, status, headers, config) {               
        funListVentam($scope.fechav);
        $scope.alertprovs = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertprove = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_ventam = function () {
    document.formlvm.rfecha.value = $scope.fechav.toJSON().slice(0,7);
  }
});
app.controller('l_venaCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.fechav = new Date();
  $scope.limites = [{value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}, {value:1000, nombre:"1000"}, {value:10000, nombre:"10000"}, {value:100000, nombre:"100000"}];
  funListVentag($scope.fechav);
  $scope.resetVent = function (fecha) {
    funListVentag(fecha);
  }
  function funListVentag (fecha) {
    $http.post('../back/vents.php?action=getg', {fechas:fecha.toJSON().slice(0,4)}).success(function (datad){
      $scope.listvpro = datad;
      $scope.currentPage = 1;
      $scope.entryLimitvp = 10;
      $scope.filteredItems = $scope.listvpro.length;
      $scope.totalItems = $scope.listvpro.length;
      if ($scope.listvpro.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }
    });
  }
  $scope.setPage = function(pageNo) {
    $scope.currentPage = pageNo;
  };
  $scope.filter = function() {
    $timeout(function() { 
      $scope.filteredItems = $scope.filtered.length;
    }, 10);
  };
  $scope.sort_by = function(predicate) {
    $scope.predicate = predicate;
    $scope.reverse = !$scope.reverse;
  };
  $scope.factVent = function (iven, icli) {
    document.fvent.rcli.value = icli;
    document.fvent.rven.value = iven;
    $("#factModal").modal('show');
  };
  $scope.cerrarDialog = function () {
    $("#factModal").modal('hide');
  }
  var bodyRef = angular.element( $document[0].body );
  $scope.editVent = function (iven,formu,detau,formd,detad,formt,detat,formc,detac) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalVent',
      controller: ModalInstanceCtrluve,
      resolve: {
        datouv: function () {
          return [iven,formu,detau,formd,detad,formt,detat,formc,detac];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      funListVentag($scope.fechav);
      if (act=="oks") {
        $scope.alertprovs = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertprove = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteVent = function (ven) {
    var confir = confirm("Está seguro de eliminar la venta, puede que afecte a la correlación?");
    if(confir) {
      $http.post('../back/vents.php?action=del', {'iven': ven})
      .success(function (data, status, headers, config) {               
        funListVentag($scope.fechav);
        $scope.alertprovs = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertprove = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_ventag = function () {
    document.formlvg.rfecha.value = $scope.fechav.toJSON().slice(0,4);
  }
});
app.controller('p_servCtrl', function ($scope, $http, $timeout, $state) {
  var psr = this;
  psr.inpsr = {};
  psr.inpsr.descus = 0;
  psr.inpsr.formu = 0;
  psr.inpsr.detau = "";
  psr.inpsr.formd = 0;
  psr.inpsr.detad = "";
  psr.inpsr.formt = 0;
  psr.inpsr.detat = "";
  psr.inpsr.formc = 0;
  psr.inpsr.detac = "";
  psr.inpsr.valid = 15;
  listarServ();
  function listarServ() {
    $http.get('../back/servs.php?action=getp').success(function (datac, status, headers, config) {
      $scope.listcat = datac;
    });
  }
  $http.get('../back/clien.php?action=sear').success(function (clisear){
    $scope.clientes = clisear;
  });
  $scope.sendServ = function () {
    var selectc = "";
    var che = $("#itemserv").find("input[type=checkbox]");
    for (var i = 0; i < che.length; i++) {
      if (che[i].checked) {
        selectc = selectc +'|'+ che[i].value+'|'+che[i].name;
      }
    }
    if (selectc=="") {
      $("#sfactModal").modal('show');
      $scope.notificacion = "Debe seleccionar o marcar por lo menos un servicio !!!";
    }
    else{
      if ($scope.icli==undefined) {
        $("#sfactModal").modal('show');
        $scope.notificacion = "Seleccione o busque al cliente !!!";
      }else{
        if ($scope.cbank==undefined || $scope.cbank=="") {
          $("#sfactModal").modal('show');
          $scope.notificacion = "Seleccione la cuenta bancaria a utilizar !!!";
        }else{
          $("#modalSFactura").modal('show');
          document.formps.rservs.value = selectc;
          document.formps.rcli.value = $scope.icli;
          psr.inpsr.cli = $scope.icli;
          psr.inpsr.sel = selectc;
          psr.inpsr.cbank = $scope.cbank;
        }
      }
    }
  }
  psr.facturarServ = function () {
    $http.post('../back/servs.php?action=pser', psr.inpsr).success(function (data) {
      $("#modalSFactura").modal('hide');
      listarServ();
      psr.inpsr = {};
      $scope.icli = {};
      $scope.cbank = "";
      $state.go('lds');
    })
    .error(function (data, status, headers, config){
      $("#modalSFactura").modal('hide');
      listarServ();
      psr.inpsr = {};
      $scope.icli = {};
      $scope.cbank = "";
    });
  }
});
app.controller('l_servdCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.fechas = new Date();
  $scope.limites = [{value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}, {value:1000, nombre:"1000"}, {value:10000, nombre:"10000"}, {value:100000, nombre:"100000"}];
  funListServiced($scope.fechas);
  $scope.resetServ = function (fecha) {
    funListServiced (fecha);
  }
  function funListServiced (fecha) {
    $http.post('../back/servs.php?action=getd', {fechas:fecha.toJSON().slice(0,10)}).success(function (datad){
      $scope.listspro = datad;
      $scope.currentPage = 1;
      $scope.entryLimitps = 10;
      $scope.filteredItems = $scope.listspro.length;
      $scope.totalItems = $scope.listspro.length;
      if ($scope.listspro.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }
    });
  }
  $scope.setPage = function(pageNo) {
    $scope.currentPage = pageNo;
  };
  $scope.filter = function() {
    $timeout(function() { 
      $scope.filteredItems = $scope.filtered.length;
    }, 10);
  };
  $scope.sort_by = function(predicate) {
    $scope.predicate = predicate;
    $scope.reverse = !$scope.reverse;
  };
  $scope.factServ = function (ipse, iser, icli) {
    document.fvent.rips.value = ipse;
    document.fvent.rcli.value = icli;
    document.fvent.rservs.value = iser;
    $("#factModal").modal('show');
  };
  $scope.cerrarDialog = function () {
    $("#factModal").modal('hide');
  }
  var bodyRef = angular.element( $document[0].body );
  $scope.editServ = function (iser,formpu,detalu,formpd,detald,formpt,detalt,formpc,detalc) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalServ',
      controller: ModalInstanceCtrluse,
      resolve: {
        datous: function () {
          return [iser,formpu,detalu,formpd,detald,formpt,detalt,formpc,detalc];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      funListServiced($scope.fechas);
      if (act=="oks") {
        $scope.alertpsers = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertpsere = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteServ = function (ser) {
    var confir = confirm("Está seguro de eliminar el servicio, puede que afecte a la correlación?");
    if(confir) {
      $http.post('../back/servs.php?action=delo', {'iser': ser})
      .success(function (data, status, headers, config) {               
        funListServiced($scope.fechas);
        $scope.alertpsers = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertpsere = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_servd = function () {
    document.formlsd.rfecha.value = $scope.fechas.toJSON().slice(0,10);
  }
});
var ModalInstanceCtrluse = function ($scope, $http, $timeout, $modalInstance, datous) {
  $scope.user = {iser: "",formu: "",detau: "",formd: "",detad: "",formt: "",detat: "",formc: "",detac: ""};
  $scope.user.iser = datous[0];
  $scope.user.formu = datous[1]*1;
  $scope.user.detau = datous[2];
  $scope.user.formd = datous[3]*1;
  $scope.user.detad = datous[4];
  $scope.user.formt = datous[5]*1;
  $scope.user.detat = datous[6];
  $scope.user.formc = datous[7]*1;
  $scope.user.detac = datous[8];
  $scope.updateServ = function(duser) {
    $http.post('../back/servs.php?action=updo', duser)
    .success(function (data, status, headers, config) {
      $modalInstance.close("oks");
      $scope.user = {};
    })
    .error(function (data, status, headers, config){
      $scope.user = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.cancelus = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('l_servmCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.fechas = new Date();
  $scope.limites = [{value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}, {value:1000, nombre:"1000"}, {value:10000, nombre:"10000"}, {value:100000, nombre:"100000"}];
  funListServicem($scope.fechas);
  $scope.resetServ = function (fecha) {
    funListServicem (fecha);
  }
  function funListServicem (fecha) {
    $http.post('../back/servs.php?action=getm', {fechas:fecha.toJSON().slice(0,7)}).success(function (datad){
      $scope.listspro = datad;
      $scope.currentPage = 1;
      $scope.entryLimitps = 10;
      $scope.filteredItems = $scope.listspro.length;
      $scope.totalItems = $scope.listspro.length;
      if ($scope.listspro.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }
    });
  }
  $scope.setPage = function(pageNo) {
    $scope.currentPage = pageNo;
  };
  $scope.filter = function() {
    $timeout(function() { 
      $scope.filteredItems = $scope.filtered.length;
    }, 10);
  };
  $scope.sort_by = function(predicate) {
    $scope.predicate = predicate;
    $scope.reverse = !$scope.reverse;
  };
  $scope.factServ = function (ipse, iser, icli) {
    document.fvent.rips.value = ipse;
    document.fvent.rcli.value = icli;
    document.fvent.rservs.value = iser;
    $("#factModal").modal('show');
  };
  $scope.cerrarDialog = function () {
    $("#factModal").modal('hide');
  }
  var bodyRef = angular.element( $document[0].body );
  $scope.editServ = function (iser,formpu,detalu,formpd,detald,formpt,detalt,formpc,detalc) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalServ',
      controller: ModalInstanceCtrluse,
      resolve: {
        datous: function () {
          return [iser,formpu,detalu,formpd,detald,formpt,detalt,formpc,detalc];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      funListServicem($scope.fechas);
      if (act=="oks") {
        $scope.alertpsers = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertpsere = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteServ = function (ser) {
    var confir = confirm("Está seguro de eliminar el servicio, puede que afecte a la correlación?");
    if(confir) {
      $http.post('../back/servs.php?action=delo', {'iser': ser})
      .success(function (data, status, headers, config) {
        funListServicem($scope.fechas);
        $scope.alertpsers = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertpsere = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_servm = function () {
    document.formlsm.rfecha.value = $scope.fechas.toJSON().slice(0,7);
  }
});
app.controller('l_servaCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.fechas = new Date();
  $scope.limites = [{value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}, {value:1000, nombre:"1000"}, {value:10000, nombre:"10000"}, {value:100000, nombre:"100000"}];
  funListServicea($scope.fechas);
  $scope.resetServ = function (fecha) {
    funListServicea(fecha);
  }
  function funListServicea (fecha) {
    $http.post('../back/servs.php?action=geta', {fechas:fecha.toJSON().slice(0,4)}).success(function (datad){
      $scope.listspro = datad;
      $scope.currentPage = 1;
      $scope.entryLimitps = 10;
      $scope.filteredItems = $scope.listspro.length;
      $scope.totalItems = $scope.listspro.length;
      if ($scope.listspro.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }
    });
  }
  $scope.setPage = function(pageNo) {
    $scope.currentPage = pageNo;
  };
  $scope.filter = function() {
    $timeout(function() { 
      $scope.filteredItems = $scope.filtered.length;
    }, 10);
  };
  $scope.sort_by = function(predicate) {
    $scope.predicate = predicate;
    $scope.reverse = !$scope.reverse;
  };
  $scope.factServ = function (ipse, iser, icli) {
    document.fvent.rips.value = ipse;
    document.fvent.rcli.value = icli;
    document.fvent.rservs.value = iser;
    $("#factModal").modal('show');
  };
  $scope.cerrarDialog = function () {
    $("#factModal").modal('hide');
  }
  var bodyRef = angular.element( $document[0].body );
  $scope.editServ = function (iser,formpu,detalu,formpd,detald,formpt,detalt,formpc,detalc) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalServ',
      controller: ModalInstanceCtrluse,
      resolve: {
        datous: function () {
          return [iser,formpu,detalu,formpd,detald,formpt,detalt,formpc,detalc];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      funListServicea($scope.fechas);
      if (act=="oks") {
        $scope.alertpsers = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertpsere = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteServ = function (ser) {
    var confir = confirm("Está seguro de eliminar el servicio, puede que afecte a la correlación?");
    if(confir) {
      $http.post('../back/servs.php?action=delo', {'iser': ser})
      .success(function (data, status, headers, config) {
        funListServicea($scope.fechas);
        $scope.alertpsers = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertpsere = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_serva = function () {
    document.formlsa.rfecha.value = $scope.fechas.toJSON().slice(0,4);
  }
});
function getLocation (proto, scope) {
  proto.get('../back/proc.json').success(function(dataci){
    scope.procity = dataci;
  });
}
function anular(e) {
  var tecla = (document.all) ? e.keyCode : e.which;
  return (tecla != 13);
}