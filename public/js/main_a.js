'use strict';
var app = angular.module('gmzbol', ['ui.router', 'ngAnimate', 'anim-in-out', 'ui.bootstrap']);
app.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
  $urlRouterProvider
    .otherwise('in');
  $stateProvider
    .state('in', {
      url: '/in',
      views: {
        "vmain": {
          title: 'Principal',
          templateUrl: '../templates/navs.php',
          controller: 'aprinCtrl'
        }
      }
    })
    .state('rv', {
      url: '/rpv',
      views: {
        "vmain": {
          title: 'Proveedor',
          templateUrl: '../templates/a_prov.php',
          controller: 'a_provCtrl',
          controllerAs: 'addpv'
         }
      }
    })
    .state('lv', {
      url: '/lpv',
      views: {
        "vmain": {
          title: 'Proveedor',
          templateUrl: '../templates/l_prov.php',
          controller: 'l_provCtrl'
        }
      }
    })
    .state('rp', {
      url: '/rpr',
      views: {
        "vmain": {
          title: 'Productos',
          templateUrl: '../templates/a_prod.php',
          controller: 'a_prodCtrl',
          controllerAs: 'addpr'
        }
      }
    })
    .state('lp', {
      url: '/lpr',
      views: {
        "vmain": {
          title: 'Productos',
          templateUrl: '../templates/l_prod.php',
          controller: 'l_prodCtrl'
         }
      }
    })
    .state('rc', {
      url: '/rrc',
      views: {
        "vmain": {
          title: 'Categoria',
          templateUrl: '../templates/a_categ.php',
          controller: 'a_categCtrl',
          controllerAs: 'addrc'
        }
      }
    })
    .state('lc', {
      url: '/lrc',
      views: {
        "vmain": {
          title: 'Categoria',
          templateUrl: '../templates/l_categ.php',
          controller: 'l_categCtrl'
        }
      }
    })
    .state('rs', {
      url: '/rsr',
      views: {
        "vmain": {
          title: 'Servicios',
          templateUrl: '../templates/a_serv.php',
          controller: 'a_servCtrl',
          controllerAs: 'addrs'
        }
      }
    })
    .state('ls', {
      url: '/lrs',
      views: {
        "vmain": {
          title: 'Servicios',
          templateUrl: '../templates/l_serv.php',
          controller: 'l_servCtrl'
        }
      }
    })
    .state('rl', {
      url: '/rcl',
      views: {
        "vmain": {
          title: 'Clientes',
          templateUrl: '../templates/a_clie.php',
          controller: 'a_clieCtrl',
          controllerAs: 'addrl'
        }
      }
    })
    .state('ll', {
      url: '/lcl',
      views: {
        "vmain": {
          title: 'Clientes',
          templateUrl: '../templates/l_clie.php',
          controller: 'l_clieCtrl'
        }
      }
    })
    .state('uc', {
      url: '/ulc',
      views: {
        "vmain": {
          title: 'Unidad',
          templateUrl: '../templates/a_unid.php',
          controller: 'a_unidCtrl',
          controllerAs: 'addun'
        }
      }
    })
    .state('ec', {
      url: '/elc',
      views: {
        "vmain": {
          title: 'Unidad',
          templateUrl: '../templates/e_demp.php',
          controller: 'e_empreCtrl'
        }
      }
    })
    .state('sc', {
      url: '/slc',
      views: {
        "vmain": {
          title: 'Serie',
          templateUrl: '../templates/c_serie.php',
          controller: 'c_serieCtrl'
        }
      }
    })
    .state('ru', {
      url: '/ru',
      views: {
        "vmain": {
          title: 'Usuario',
          templateUrl: '../templates/a_user.php',
          controller: 'a_userCtrl',
          controllerAs: 'addru'
        }
      }
    })
    .state('lu', {
      url: '/lu',
      views: {
        "vmain": {
          title: 'Usuario',
          templateUrl: '../templates/l_user.php',
          controller: 'l_userCtrl'
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
app.controller('a_provCtrl', function ($scope, $http) {
  var prv = this;
  prv.inprv = {};
  prv.inprv.prvnit = 0;
  prv.sendprov = function () {
    $http.post('../back/provs.php?action=add', prv.inprv).success(function(data){
      prv.inprv = {};
      if (data=="ok") {
        $scope.alertprovs = true;
        $scope.messages = "Registro efectuado con éxito !!!";
      }
    })
    .error(function(data){
      prv.inprv = {};
      $scope.alertprove = true;
      $scope.messages = "Error al enviar los datos !!! - " + data;
    });
  }
});
app.controller('l_provCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.limites = [{value:5, nombre:"5"}, {value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}];
  $timeout(funSelectprov ,100);
  $scope.actpdf = true;
  function funSelectprov () {
    $http.get('../back/provs.php?action=get').success(function (data){
      $scope.listprv = data;
      $scope.currentPage = 1;
      $scope.entryLimitprv = 5;
      $scope.filteredItems = $scope.listprv.length;
      $scope.totalItems = $scope.listprv.length;
      if ($scope.listprv.length>0) {
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
  var bodyRef = angular.element( $document[0].body );
  $scope.editProv = function(idprv,name,nit,cont,pais,telf,celu,dire,fechai,estado) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalProv',
      controller: ModalInstanceCtrlprv,
      resolve: {
        datoprv: function () {
          return [idprv,name,nit,cont,pais,telf,celu,dire,fechai,estado];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      $timeout(funSelectprov ,100);
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
  $scope.deleteProv = function (iprov) {
    var confir = confirm("Está seguro de eliminar al proveedor?");
    if(confir) {
      $http.post('../back/provs.php?action=del', {'idpers': iprov})
      .success(function (data, status, headers, config) {               
        $timeout(funSelectprov ,100);
        $scope.alertprovs = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertprove = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_proveedor = function () {
    var vnomb ="";
    var vnit ="";
    var vcont ="";
    var vpais ="";
    var vtefl ="";
    var vdire ="";
    var vesta ="";
    var f;
    var d=document.getElementById("datalprv");
    var tabla=d.firstChild;
    if(tabla.nextSibling!=null)
        tabla=tabla.nextSibling;
    for(f=1;f<tabla.rows.length; f++) {
      if(f==1) {
        vnomb=tabla.rows[f].cells[1].innerHTML;
        vnit=tabla.rows[f].cells[2].innerHTML;
        vcont=tabla.rows[f].cells[3].innerHTML;
        vpais=tabla.rows[f].cells[4].innerHTML;
        vtefl=tabla.rows[f].cells[5].innerHTML;
        vdire=tabla.rows[f].cells[6].innerHTML;
        vesta=tabla.rows[f].cells[7].firstChild.innerHTML;
      }
      else {
        vnomb=vnomb+"|"+tabla.rows[f].cells[1].innerHTML;
        vnit=vnit+"|"+tabla.rows[f].cells[2].innerHTML;
        vcont=vcont+"|"+tabla.rows[f].cells[3].innerHTML;
        vpais=vpais+"|"+tabla.rows[f].cells[4].innerHTML;
        vtefl=vtefl+"|"+tabla.rows[f].cells[5].innerHTML;
        vdire=vdire+"|"+tabla.rows[f].cells[6].innerHTML;
        vesta=vesta+"|"+tabla.rows[f].cells[7].firstChild.innerHTML;
      }
    }
    document.formlprv.rnomb.value = vnomb;
    document.formlprv.rnit.value = vnit;
    document.formlprv.rcont.value = vcont;
    document.formlprv.rpais.value = vpais;
    document.formlprv.rtefl.value = vtefl;
    document.formlprv.rdire.value = vdire;
    document.formlprv.resta.value = vesta;
  }
});
var ModalInstanceCtrlprv = function ($scope, $http, $timeout, $modalInstance, datoprv) {
  $scope.prov = {iprv: "",paname: "",panit: "",pacont: "",papais: "",pafechi: "",patelf: "",pacelu: "",padir: "",paest: ""};  
  $scope.prov.iprv = datoprv[0];
  $scope.prov.paname = datoprv[1];
  $scope.prov.panit = datoprv[2];
  $scope.prov.pacont = datoprv[3];
  $scope.prov.papais = datoprv[4];
  $scope.prov.pafechi = datoprv[9];
  $scope.prov.patelf = datoprv[5]*1;
  $scope.prov.pacelu = datoprv[6]*1;
  $scope.prov.padir = datoprv[7];
  $scope.prov.paest = datoprv[9]*1;
  $scope.updateProv = function(dprov) {
    $http.post('../back/provs.php?action=upd', dprov)
    .success(function (data, status, headers, config) {
      $scope.prov = {};
      $modalInstance.close("oks");
    })
    .error(function (data, status, headers, config){
      $scope.prov = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.cancelprv = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('a_prodCtrl', function ($scope, $http, $timeout) {
  $timeout(function(){
    getListUnid($http, $scope);
  },100);
  $timeout(function(){
    getListProv($http, $scope);
  },100);
  var pro = this;
  pro.inpro = {};
  pro.sendprod = function () {
    if(pro.inpro.prounid==undefined){
      $("#prodModal").modal('show');
      $scope.notificacion = "Seleccione unidad !!!";
    }else{
      if(pro.inpro.proprov==undefined){
        $("#prodModal").modal('show');
        $scope.notificacion = "Seleccione proveedor !!!";
      }
      else{
        pro.inpro.profoto = $("#auximgp").val();
        $http.post('../back/prods.php?action=add', pro.inpro).success(function (data){
          pro.inpro = {};
          if (data=="ok") {
            pro.inpro.profoto = "";
            $("#pimg").val("");
            $('#imgloadp').attr("src", "../public/img/base.png");
            $('#imgloadp').attr("width", "200px");
            $('#imgloadp').attr("height", "160px");
            $scope.alertprods = true;
            $scope.messages = "Registro efectuado con éxito !!!";
          }
        })
        .error(function(data){
          pro.inpro = {};
          $scope.alertprode = true;
          $scope.messages = "Error al enviar los datos !!! - " + data;
        });
      }
    }
  }
});
app.controller('l_prodCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.limites = [{value:5, nombre:"5"}, {value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}];
  $timeout(funSelectprod ,100);
  $scope.actpdf = true;
  function funSelectprod () {
    $http.get('../back/prods.php?action=get').success(function (data){
      $scope.listpro = data;
      $scope.currentPage = 1;
      $scope.entryLimitpro = 5;
      $scope.filteredItems = $scope.listpro.length;
      $scope.totalItems = $scope.listpro.length;
      if ($scope.listpro.length>0) {
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
  var bodyRef = angular.element( $document[0].body );
  $scope.editProd = function(ipro,iprv,nomb,desc,cant,proc,fech,foto,esta) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalProd',
      controller: ModalInstanceCtrlpro,
      resolve: {
        datopro: function () {
          return [ipro,iprv,nomb,desc,cant,proc,fech,foto,esta];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      $timeout(funSelectprod ,100);
      if (act=="oks") {
        $scope.alertprods = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertprode = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteProd = function (iprod, foto) {
    var confir = confirm("Está seguro de eliminar al producto?");
    if(confir) {
      $http.post('../back/prods.php?action=del', {'ipro': iprod, 'fot': foto})
      .success(function (data, status, headers, config) {               
        $timeout(funSelectprod ,100);
        $scope.alertprods = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertprode = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_productos = function () {
    var vnomb ="";
    var vprov ="";
    var vcant ="";
    var vprec ="";
    var vdesc ="";
    var vfech ="";
    var vesta ="";
    var f;
    var d=document.getElementById("datalpro");
    var tabla=d.firstChild;
    if(tabla.nextSibling!=null)
        tabla=tabla.nextSibling;
    for(f=1;f<tabla.rows.length; f++) {
      if(f==1) {
        vnomb=tabla.rows[f].cells[1].innerHTML;
        vprov=tabla.rows[f].cells[2].innerHTML;
        vcant=tabla.rows[f].cells[3].innerHTML;
        vprec=tabla.rows[f].cells[4].innerHTML;
        vfech=tabla.rows[f].cells[5].innerHTML;
        vdesc=tabla.rows[f].cells[6].innerHTML;
        vesta=tabla.rows[f].cells[7].firstChild.innerHTML;
      }
      else {
        vnomb=vnomb+"|"+tabla.rows[f].cells[1].innerHTML;
        vprov=vprov+"|"+tabla.rows[f].cells[2].innerHTML;
        vcant=vcant+"|"+tabla.rows[f].cells[3].innerHTML;
        vprec=vprec+"|"+tabla.rows[f].cells[4].innerHTML;
        vfech=vfech+"|"+tabla.rows[f].cells[5].innerHTML;
        vdesc=vdesc+"|"+tabla.rows[f].cells[6].innerHTML;
        vesta=vesta+"|"+tabla.rows[f].cells[7].firstChild.innerHTML;
      }
    }
    document.formlpro.rnomb.value = vnomb;
    document.formlpro.rprov.value = vprov;
    document.formlpro.rfech.value = vfech;
    document.formlpro.rcant.value = vcant;
    document.formlpro.rprec.value = vprec;
    document.formlpro.rdesc.value = vdesc;
    document.formlpro.resta.value = vesta;
  }
});
var ModalInstanceCtrlpro = function ($scope, $http, $timeout, $modalInstance, datopro) {
  $scope.prod = {ipro: "",iprv: "",pnomb: "",pdesc: "",pcant: "",pprec: "",pfech: "",pfotoa: "",pfoton: "",pesta: ""};
  $timeout(function(){
    getListProv($http, $scope);
  },100);
  $scope.prod.ipro = datopro[0];
  $scope.prod.iprv = datopro[1];
  $scope.prod.pnomb = datopro[2];
  $scope.prod.pdesc = datopro[3];
  $scope.prod.pcant = datopro[4]*1;
  $scope.prod.pprec = datopro[5];
  $scope.prod.pfech = datopro[6];
  $scope.prod.pesta = datopro[8]*1;
  if (datopro[7]!="") {
    $scope.mostrarimg = "../public/img/prods/"+datopro[7];
    $scope.nombreimg = datopro[7];
  }else{
    $scope.mostrarimg = "../public/img/base.png";
    $scope.nombreimg = "";
  }
  $scope.updateProd = function(dprod) {
    dprod.pfotoa = document.getElementById("nombreimg").innerHTML;
    dprod.pfoton = document.getElementById("nombreimgn").innerHTML;
    $http.post('../back/prods.php?action=upd', dprod)
    .success(function (data, status, headers, config) {
      $modalInstance.close("oks");
      $scope.prod = {};
    })
    .error(function (data, status, headers, config){
      $scope.prod = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.cancelpro = function () {
    if (document.getElementById("nombreimgn").innerHTML==document.getElementById("nombreimg").innerHTML || document.getElementById("nombreimgn").innerHTML=="") {
      $modalInstance.dismiss('cancel');
    } else {
      $scope.nota = 'actualizar';
    }
  };
};
app.controller('a_categCtrl', function ($scope, $http) {
  var cat = this;
  cat.incat = {};
  cat.incat.catest = 1;
  cat.sendCateg = function () {
    $http.post('../back/categs.php?action=add', cat.incat).success(function (data){
      cat.incat = {};
      cat.incat.catest = 1;
      if (data=="ok") {
        $scope.alertcats = true;
        $scope.messages = "Registro efectuado con éxito !!!";
      }
    })
    .error(function (data){
      cat.incat = {};
      cat.incat.catest = 1;
      $scope.alertcate = true;
      $scope.messages = "Error al enviar los datos !!! - " + data;
    });
  }
});
app.controller('l_categCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.limites = [{value:5, nombre:"5"}, {value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}];
  $timeout(funSelectcat ,100);
  $scope.actpdf = true;
  function funSelectcat () {
    $http.get('../back/categs.php?action=get').success(function (data){
      $scope.listcat = data;
      $scope.currentPage = 1;
      $scope.entryLimitcat = 5;
      $scope.filteredItems = $scope.listcat.length;
      $scope.totalItems = $scope.listcat.length;
      if ($scope.listcat.length>0) {
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
  var bodyRef = angular.element( $document[0].body );
  $scope.editCateg = function(icat,descat,estadocat) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalCat',
      controller: ModalInstanceCtrlcat,
      resolve: {
        datocat: function () {
          return [icat,descat,estadocat];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      $timeout(funSelectcat ,100);
      if (act=="oks") {
        $scope.alertcats = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertcate = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteCateg = function (icats) {
    var confir = confirm("Está seguro de eliminar la categoria?");
    if(confir) {
      $http.post('../back/categs.php?action=del', {'icat': icats})
      .success(function (data, status, headers, config) {               
        $timeout(funSelectcat ,100);
        $scope.alertcats = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertcate = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_categorias = function () {
    var vdesc ="";
    var vesta ="";
    var f;
    var d=document.getElementById("datalcat");
    var tabla=d.firstChild;
    if(tabla.nextSibling!=null)
        tabla=tabla.nextSibling;
    for(f=1;f<tabla.rows.length; f++) {
      if(f==1) {
        vdesc=tabla.rows[f].cells[1].innerHTML;
        vesta=tabla.rows[f].cells[2].firstChild.innerHTML;
      }
      else {
        vdesc=vdesc+"|"+tabla.rows[f].cells[1].innerHTML;
        vesta=vesta+"|"+tabla.rows[f].cells[2].firstChild.innerHTML;
      }
    }
    document.formlcat.rdesc.value = vdesc;
    document.formlcat.resta.value = vesta;
  }
});
var ModalInstanceCtrlcat = function ($scope, $http, $timeout, $modalInstance, datocat) {
  $scope.cats = {icat: "",descat: "",estcat: ""};
  $scope.cats.icat = datocat[0];
  $scope.cats.descat = datocat[1];
  $scope.cats.estcat = datocat[2]*1;
  $scope.updateCateg = function(dcats) {
    $http.post('../back/categs.php?action=upd', dcats)
    .success(function (data, status, headers, config) {
      if (data=="ok") {
        $modalInstance.close("oks");
        $scope.cats = {};
      }
    })
    .error(function (data, status, headers, config){
      $scope.cats = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.cancelcat = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('a_servCtrl', function ($scope, $http, $timeout) {
  var ser = this;
  ser.inser = {};
  $timeout(function(){
    getCategory($http, $scope);
  },100);
  ser.sendServ = function () {
    if(ser.inser.sercat==undefined){
      $("#servModal").modal('show');
      $scope.notificacion = "Seleccione categoria !!!";
    }
    else{
      $http.post('../back/servs.php?action=add', ser.inser).success(function (data){
        ser.inser = {};
        if (data=="ok") {
          $scope.alertcats = true;
          $scope.messages = "Registro efectuado con éxito !!!";
        }
      })
      .error(function (data){
        ser.inser = {};
        $scope.alertcate = true;
        $scope.messages = "Error al enviar los datos !!! - " + data;
      });
    }
  }
});
app.controller('l_servCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $timeout(function(){
    getCategory($http, $scope);
  },100);
  $scope.limites = [{value:5, nombre:"5"}, {value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}];
  $scope.entryLimitser = 5;
  $scope.actsearch = true;
  $scope.actpdf = true;
  $scope.selectCateg = function (idc) {
    if (idc!=null) {
      $scope.actsearch = false;
      funSelectserv(idc);
    }else{
      $scope.actsearch = true;
      $scope.filteredItems = 0;
      $scope.totalItems = 0;
    }
  }
  function funSelectserv (idcat) {
    $http.get('../back/servs.php?action=getc'+'&idc='+idcat).success(function (data){
      $scope.listser = data;
      $scope.currentPage = 1;
      $scope.entryLimitpersc = 5;
      $scope.filteredItems = $scope.listser.length;
      $scope.totalItems = $scope.listser.length;
      if ($scope.listser.length>0) {
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
  var bodyRef = angular.element( $document[0].body );
  $scope.editServ = function(iser,desc,icat,fech,cost,obse,esta) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalServ',
      controller: ModalInstanceCtrlser,
      resolve: {
        datoser: function () {
          return [iser,desc,icat,fech,cost,obse,esta];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      $timeout(function(){
        funSelectserv($scope.catserv);
      },100);
      if (act=="oks") {
        $scope.alertsers = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertsere = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteServ = function (iserv) {
    var confir = confirm("Está seguro de eliminar el servicio?");
    if(confir) {
      $http.post('../back/servs.php?action=del', {'iser': iserv})
      .success(function (data, status, headers, config) {               
        $timeout(function(){
          funSelectserv($scope.catserv);
        },100);
        $scope.alertsers = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertsere = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_servicios = function () {
    var vdesc ="";
    var vfech ="";
    var vcost ="";
    var vobse ="";
    var vesta ="";
    var f;
    var d=document.getElementById("datalser");
    var tabla=d.firstChild;
    if(tabla.nextSibling!=null)
        tabla=tabla.nextSibling;
    for(f=1;f<tabla.rows.length; f++) {
      if(f==1) {
        vdesc=tabla.rows[f].cells[1].innerHTML;
        vfech=tabla.rows[f].cells[2].innerHTML;
        vcost=tabla.rows[f].cells[3].innerHTML;
        vobse=tabla.rows[f].cells[4].innerHTML;
        vesta=tabla.rows[f].cells[5].firstChild.innerHTML;
      }
      else {
        vdesc=vdesc+"|"+tabla.rows[f].cells[1].innerHTML;
        vfech=vfech+"|"+tabla.rows[f].cells[2].innerHTML;
        vcost=vcost+"|"+tabla.rows[f].cells[3].innerHTML;
        vobse=vobse+"|"+tabla.rows[f].cells[4].innerHTML;
        vesta=vesta+"|"+tabla.rows[f].cells[5].firstChild.innerHTML;
      }
    }
    document.formlser.rdesc.value = vdesc;
    document.formlser.rfech.value = vfech;
    document.formlser.rcost.value = vcost;
    document.formlser.robse.value = vobse;
    document.formlser.resta.value = vesta;
    document.formlser.resta.value = vesta;
    document.formlser.rcateg.value = $("select#catserv option:selected").html();
  }
});
var ModalInstanceCtrlser = function ($scope, $http, $timeout, $modalInstance, datoser) {
  $timeout(function(){
    getCategory($http, $scope);
  },100);
  $scope.serv = {icat: "",desser: "",catser: "",fechser: "",cosser: "",obsser: "",estser: ""};
  $scope.serv.iser = datoser[0];
  $scope.serv.desser = datoser[1];
  $scope.serv.catser = datoser[2];
  $scope.serv.fechser = datoser[3];
  $scope.serv.cosser = datoser[4];
  $scope.serv.obsser = datoser[5];
  $scope.serv.estser = datoser[6]*1;
  $scope.updateServ = function(dser) {
    $http.post('../back/servs.php?action=upd', dser)
    .success(function (data, status, headers, config) {
      if (data=="ok") {
        $modalInstance.close("oks");
        $scope.serv = {};
      }
    })
    .error(function (data, status, headers, config){
      $scope.serv = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.cancelser = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('a_clieCtrl', function ($scope, $http, $timeout) {
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
    }
    else{
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
app.controller('l_clieCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.limites = [{value:5, nombre:"5"}, {value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}];
  $scope.actpdf = true;
  $timeout(funSelectclie, 100);
  function funSelectclie () {
    $http.get('../back/clien.php?action=get').success(function (data){
      $scope.listcli = data;
      $scope.currentPage = 1;
      $scope.entryLimitcli = 5;
      $scope.filteredItems = $scope.listcli.length;
      $scope.totalItems = $scope.listcli.length;
      if ($scope.listcli.length>0) {
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
  var bodyRef = angular.element( $document[0].body );
  $scope.editClie = function(icli,clie,nit,telf,celu,mail,tipo,fech,ciud,dire,esta) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalClie',
      controller: ModalInstanceCtrlcli,
      resolve: {
        datocli: function () {
          return [icli,clie,nit,telf,celu,mail,tipo,fech,ciud,dire,esta];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      $timeout(funSelectclie, 100);
      if (act=="oks") {
        $scope.alertclis = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertclie = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteClie = function (iclie) {
    var confir = confirm("Está seguro de eliminar al cliente?");
    if(confir) {
      $http.post('../back/clien.php?action=del', {'iser': iclie})
      .success(function (data, status, headers, config) {               
        $timeout(funSelectclie, 100);
        $scope.alertclis = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertclie = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
  $scope.prn_clientes = function () {
    var vnomb ="";
    var vnitc ="";
    var vtelf ="";
    var vcorr ="";
    var vtipo ="";
    var vfech ="";
    var vciud ="";
    var vdire ="";
    var vesta ="";
    var f;
    var d=document.getElementById("datalcli");
    var tabla=d.firstChild;
    if(tabla.nextSibling!=null)
        tabla=tabla.nextSibling;
    for(f=1;f<tabla.rows.length; f++) {
      if(f==1) {
        vnomb=tabla.rows[f].cells[1].innerHTML;
        vnitc=tabla.rows[f].cells[2].innerHTML;
        vtelf=tabla.rows[f].cells[3].innerHTML;
        vcorr=tabla.rows[f].cells[4].innerHTML;
        vtipo=tabla.rows[f].cells[5].innerHTML;
        vfech=tabla.rows[f].cells[6].innerHTML;
        vciud=tabla.rows[f].cells[7].innerHTML;
        vdire=tabla.rows[f].cells[8].innerHTML;
        vesta=tabla.rows[f].cells[9].firstChild.innerHTML;
      }else {
        vnomb=vnomb+"|"+tabla.rows[f].cells[1].innerHTML;
        vnitc=vnitc+"|"+tabla.rows[f].cells[2].innerHTML;
        vtelf=vtelf+"|"+tabla.rows[f].cells[3].innerHTML;
        vcorr=vcorr+"|"+tabla.rows[f].cells[4].innerHTML;
        vtipo=vtipo+"|"+tabla.rows[f].cells[5].innerHTML;
        vfech=vfech+"|"+tabla.rows[f].cells[6].innerHTML;
        vciud=vciud+"|"+tabla.rows[f].cells[7].innerHTML;
        vdire=vdire+"|"+tabla.rows[f].cells[8].innerHTML;
        vesta=vesta+"|"+tabla.rows[f].cells[9].firstChild.innerHTML;
      }
    }
    document.formlcli.rnomb.value = vnomb;
    document.formlcli.rnitc.value = vnitc;
    document.formlcli.rtelf.value = vtelf;
    document.formlcli.rcorr.value = vcorr;
    document.formlcli.rtipo.value = vtipo;
    document.formlcli.rfech.value = vfech;
    document.formlcli.rciud.value = vciud;
    document.formlcli.rdire.value = vdire;
    document.formlcli.resta.value = vesta;
  }
});
var ModalInstanceCtrlcli = function ($scope, $http, $timeout, $modalInstance, datocli) {
  $timeout(function(){
    getLocation($http, $scope);
  },100);
  $scope.clie = {icli: "",nomcli: "",nitcli: "",telcli: "",celcli: "",corcli: "",tipcli: "",fechcli: "",ciucli: "",dircli: "",estcli: ""};
  $scope.clie.icli = datocli[0];
  $scope.clie.nomcli = datocli[1];
  $scope.clie.nitcli = datocli[2];
  $scope.clie.telcli = datocli[3]*1;
  $scope.clie.celcli = datocli[4]*1;
  $scope.clie.corcli = datocli[5];
  $scope.clie.tipcli = datocli[6]*1;
  $scope.clie.fechcli = datocli[7];
  $scope.clie.ciucli = datocli[8]*1;
  $scope.clie.dircli = datocli[9];
  $scope.clie.estcli = datocli[10]*1;
  $scope.updateClie = function(dcli) {
    $http.post('../back/clien.php?action=upd', dcli)
    .success(function (data, status, headers, config) {
      if (data=="ok") {
        $modalInstance.close("oks");
        $scope.clie = {};
      }
    })
    .error(function (data, status, headers, config){
      $scope.clie = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.cancelcli = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('a_unidCtrl', function ($scope, $http, $timeout, $modal, $document) {
  var uni = this;
  uni.inuni = {};
  uni.sendUnid = function () {
    $http.post('../back/unids.php?action=add', uni.inuni).success(function (data){
      uni.inuni = {};
      if (data=="ok") {
        $scope.alertunis = true;
        $scope.messages = "Registro efectuado con éxito !!!";
        $timeout(funSelectun ,100);
        $timeout(function() {$scope.alertunis = false;}, 1500);
      }
    })
    .error(function (data){
      uni.inuni = {};
      $scope.alertunie = true;
      $scope.messages = "Error al enviar los datos !!! - " + data;
      $timeout(function() {$scope.alertunie = false;}, 1500);
    });
  }
  $scope.limites = [{value:5, nombre:"5"}, {value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}];
  $timeout(funSelectun ,100);
  /*$scope.actpdf = true;*/
  function funSelectun () {
    $http.get('../back/unids.php?action=getl').success(function (data){
      $scope.listun = data;
      $scope.currentPage = 1;
      $scope.entryLimitun = 5;
      $scope.filteredItems = $scope.listun.length;
      $scope.totalItems = $scope.listun.length;
      /*if ($scope.listun.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }*/
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
  var bodyRef = angular.element( $document[0].body );
  $scope.editUnid = function(iun,desun,estadou) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalUni',
      controller: ModalInstanceCtrlun,
      resolve: {
        datoun: function () {
          return [iun,desun,estadou];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      $timeout(funSelectun ,100);
      if (act=="oks") {
        $scope.alertunis = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
        $timeout(function() {$scope.alertunis = false;}, 1500);
      }
      else{
        $scope.alertunie = true;
        $scope.messages = act;
        $timeout(function() {$scope.alertunie = false;}, 1500);
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteUnid = function (iun) {
    var confir = confirm("Está seguro de eliminar la unidad?");
    if(confir) {
      $http.post('../back/unids.php?action=del', {'iun': iun})
      .success(function (data, status, headers, config) {               
        $timeout(funSelectun ,100);
        $scope.alertcats = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertcate = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
});
var ModalInstanceCtrlun = function ($scope, $http, $timeout, $modalInstance, datoun) {
  $scope.uni = {iun: "",desun: "",estun: ""};
  $scope.uni.iun = datoun[0];
  $scope.uni.desun = datoun[1];
  $scope.uni.estun = datoun[2]*1;
  $scope.updateUnid = function(duni) {
    $http.post('../back/unids.php?action=upd', duni)
    .success(function (data, status, headers, config) {
      if (data=="ok") {
        $modalInstance.close("oks");
        $scope.uni = {};
      }
    })
    .error(function (data, status, headers, config){
      $scope.uni = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.cancelun = function () {
    $modalInstance.dismiss('cancel');
  };
};
app.controller('e_empreCtrl', function ($scope, $http, $timeout) {
  $scope.inemp = {iem: "",raz: "",num: "",zon: "",tel: "",mai: "",ban: "",cun: "",cue: "",band: "",cund: "",cued: ""};
  funEditemp();
  function funEditemp () {
    $http.get('../back/emps.php?action=get').success(function (data){
      $scope.inemp.iem = data.iemp;
      $scope.inemp.raz = data.razon;
      $scope.inemp.num = data.numer;
      $scope.inemp.zon = data.zonae;
      $scope.inemp.tel = data.telf;
      $scope.inemp.mai = data.mail;
      $scope.inemp.ban = data.banco;
      $scope.inemp.cun = data.cuemn;
      $scope.inemp.cue = data.cueme;
      $scope.inemp.band = data.bancod;
      $scope.inemp.cund = data.cuemnd;
      $scope.inemp.cued = data.cuemed;
    });
  }
  $scope.updateEmp = function (demp) {
    $http.post('../back/emps.php?action=upd', demp)
    .success(function (data, status, headers, config) {
      if (data=="ok") {
        $scope.inemp={};
        $scope.alertemps = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
        $timeout(function() {funEditemp();$scope.alertemps = false;}, 1500);
      }
    })
    .error(function (data, status, headers, config){
      $scope.inemp={};
      $scope.alertempe = true;
      $scope.messages = "Error al actualizar !!!";
      $timeout(function() {$scope.alertempe = false;}, 1500);
    });
  }
});
app.controller('c_serieCtrl', function ($scope, $http, $timeout) {
  funSelectserie();
  function funSelectserie () {
    $http.get('../back/serivs.php?action=get').success(function (data){
      $scope.sventa = data.seve;
      $scope.sservi = data.sese;
    });
  }
  $scope.sendSVent = function () {
    if ($scope.sventa>0) {
      $http.post('../back/serivs.php?action=addsv', {num:$scope.sventa}).success(function (data){
        if (data=="ok") {
          $scope.alertseris = true;
          $scope.messages = "Registro efectuado con éxito !!!";
          $timeout(function() {$scope.alertseris = false;}, 1500);
          funSelectserie();
        }
      })
      .error(function (data){
        $scope.alertserie = true;
        $scope.messages = "Error al enviar los datos !!!";
        $timeout(function() {$scope.alertserie = false;}, 1500);
        funSelectserie();
      });
    } else {
      $("#serieModal").modal('show');
      $scope.notificacion = "El número ingresado debe ser mayor que 0 !!!";
    }
  }
  $scope.sendSServ = function () {
    if ($scope.sservi>0) {
      $http.post('../back/serivs.php?action=addss', {num:$scope.sservi}).success(function (data){
        if (data=="ok") {
          $scope.alertseris = true;
          $scope.messages = "Registro efectuado con éxito !!!";
          $timeout(function() {$scope.alertseris = false;}, 1500);
          funSelectserie();
        }
      })
      .error(function (data){
        $scope.alertserie = true;
        $scope.messages = "Error al enviar los datos !!!";
        $timeout(function() {$scope.alertserie = false;}, 1500);
        funSelectserie();
      });
    } else {
      $("#serieModal").modal('show');
      $scope.notificacion = "El número ingresado debe ser mayor que 0 !!!";
    }
  }
});
app.controller('a_userCtrl', function ($scope, $http, $timeout) {
  getLocation($http, $scope);
  var use = this;
  use.inuse = {};
  use.sendUser = function () {
    if (use.inuse.usepro==undefined) {
      $("#userModal").modal('show');
      $scope.notificacion = "Seleccione procedencia !!!";
    }
    else{
      $http.post('../back/users.php?action=add', use.inuse).success(function (data){
        use.inuse = {};
        if (data=="ok") {
          $scope.alertuses = true;
          $scope.messages = "Registro efectuado con éxito !!!";
          $timeout(function() {$scope.alertuses = false;}, 1500);
        }
      })
      .error(function (data){
        use.inuse = {};/////
        $scope.alertusee = true;
        $scope.messages = "Error al enviar los datos !!! - " + data;
        $timeout(function() {$scope.alertusee = false;}, 1500);
      });
    }
  }
});
app.controller('l_userCtrl', function ($scope, $http, $timeout, $modal, $document) {
  $scope.limites = [{value:10, nombre:"10"}, {value:15, nombre:"15"}, {value:20, nombre:"20"}, {value:25, nombre:"25"}, {value:50, nombre:"50"}, {value:100, nombre:"100"}];
  $timeout(funSelectuser ,100);
  //$scope.actpdf = true;
  function funSelectuser () {
    $http.get('../back/users.php?action=get').success(function (data){
      $scope.listuse = data;
      $scope.currentPage = 1;
      $scope.entryLimituse = 10;
      $scope.filteredItems = $scope.listuse.length;
      $scope.totalItems = $scope.listuse.length;
      /*if ($scope.listuse.length>0) {
        $scope.actpdf = false;
      }else{
        $scope.actpdf = true;
      }*/
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
  var bodyRef = angular.element( $document[0].body );
  $scope.editUser = function(ius,use,nomb,dni,proc,carg,telf,corr,dire,est) {
    bodyRef.addClass('ovh');
    var modalInstance = $modal.open({
      templateUrl: 'modalUser',
      controller: ModalInstanceCtrlu,
      resolve: {
        datous: function () {
          return [ius,use,nomb,dni,proc,carg,telf,corr,dire,est];
        }
      }
    });
    modalInstance.result.then(function (act) {
      bodyRef.removeClass('ovh');
      $timeout(funSelectuser ,100);
      if (act=="oks") {
        $scope.alertuses = true;
        $scope.messages = "Actualización efectuado con éxito !!!";
      }
      else{
        $scope.alertusee = true;
        $scope.messages = act;
      }
    }, function () {
      bodyRef.removeClass('ovh');
    });
  };
  $scope.deleteUser = function (iuse) {
    var confir = confirm("Está seguro de eliminar al usuario?");
    if(confir) {
      $http.post('../back/users.php?action=del', {'ius': iuse})
      .success(function (data, status, headers, config) {               
        $timeout(funSelectuser ,100);
        $scope.alertuses = true;
        $scope.messages = "Eliminación efectuado con éxito !!!";
      })
      .error(function (data, status, headers, config){
        $scope.alertusee = true;
        $scope.messages = "Error al eliminar los datos !!! - ";
      });
    }
  };
});
var ModalInstanceCtrlu = function ($scope, $http, $timeout, $modalInstance, datous) {
  $scope.use = {ius: "",uusu: "",unom: "",udni: "",upro: "",ucar: "",utel: "",ucor: "",udir: "",ucla: "",uest: ""};
  $timeout(function(){
    getLocation($http, $scope);
  },100);
  $scope.use.ius = datous[0];
  $scope.use.uusu = datous[1];
  $scope.use.unom = datous[2];
  $scope.use.udni = datous[3]*1;
  $scope.use.upro = datous[4]*1;
  $scope.use.ucar = datous[5];
  $scope.use.utel = datous[6]*1;
  $scope.use.ucor = datous[7];
  $scope.use.udir = datous[8];
  $scope.use.uest = datous[9]*1;
  $scope.actinp = function (par) {
    if(par==true){
      $("input#ucla").prop('disabled', false);
    }else{
      $scope.use.ucla = "";
      $("input#ucla").prop('disabled', true);
    }
  }
  $scope.updateUser = function(duse) {
    $http.post('../back/users.php?action=upd', duse)
    .success(function (data, status, headers, config) {
      $modalInstance.close("oks");
      $scope.use = {};
    })
    .error(function (data, status, headers, config){
      $scope.use = {};
      $modalInstance.close("Error al actualizar los datos !!! - " + data);
    });
  };
  $scope.canceluse = function () {
    $modalInstance.dismiss('cancel');
  };
};
function getLocation (proto, scope) {
  proto.get('../back/proc.json').success(function(dataci){
    scope.procity = dataci;
  });
}
function getListProv (proto, scope) {
  proto.get('../back/provs.php?action=getl').success(function(dataprv){
    scope.listprov = dataprv;
  });
}
function getCategory (proto, scope) {
  proto.get('../back/categs.php?action=getl').success(function(datac){
    scope.categs = datac;
  });
}
function getListUnid (proto, scope) {
  proto.get('../back/unids.php?action=get').success(function(dataunid){
    scope.listunid = dataunid;
  });
}
function uploadImgp () {
  var file = $("#pimg")[0].files[0];
  var fileName = file.name;
  var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
  var formData = new FormData($(".formp")[0]);
  var message = "";
  $.ajax({
      url: '../back/uploadimgp.php',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function(){
        $('#imgloadp').attr("src", "../public/img/loading.gif");
        $('#imgloadp').attr("width", "50px");
        $('#imgloadp').attr("height", "50px");
      },
      success: function(data){
        if(isImage(fileExtension)){
          $('#imgloadp').attr("src", "../public/img/prods/"+data);
          $('#imgloadp').attr("width", "135px");
          $('#imgloadp').attr("height", "135px");
          $("#auximgp").val(data);
          $("#delfot").css("display", "inline-block");
        }
      },
      error: function(){
        $('#imgloadp').attr("src", "../public/img/error.png");
        $('#imgloadp').attr("width", "100px");
        $('#imgloadp').attr("height", "50px");
      }
  });
}
function changeImgp () {
  document.getElementById('nimg').value = document.getElementById("nombreimg").innerHTML;
  var file = angular.element($("#updfot")[0].files[0]);
  var fileName = file[0].name;
  var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
  var formData = new FormData($(".formp")[0]);
  var message = "";
  $.ajax({
      url: '../back/changeimgp.php',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function(){
        $('#imgloadp').attr("src", "../public/img/loading.gif");
        $('#imgloadp').attr("width", "50px");
        $('#imgloadp').attr("height", "50px");
      },
      success: function(data){
        if(isImage(fileExtension)){
          $('#imgloadp').attr("src", "../public/img/prods/"+data);
          $('#imgloadp').attr("width", "100px");
          $('#imgloadp').attr("height", "100px");
          document.getElementById("nombreimgn").innerHTML = data;
        }
      },
      error: function(){
        $('#imgloadp').attr("src", "../public/img/error.png");
        $('#imgloadp').attr("width", "100px");
        $('#imgloadp').attr("height", "50px");
      }
  });
}
function isImage(extension) {
  switch(extension.toLowerCase()) {
      case 'jpg': case 'gif': case 'png': case 'jpeg':
          return true;
      break;
      default:
          return false;
      break;
  }
}
function deleteImgp() {
  $.ajax({
      url: '../back/deleteimgp.php',
      type: 'POST',
      data: "fot="+$("#auximgp").val(),
      beforeSend: function(){
        $('#imgloadp').attr("src", "../public/img/loading.gif");
        $('#imgloadp').attr("width", "50px");
        $('#imgloadp').attr("height", "50px");
      },
      success: function(data){
        $('#imgloadp').attr("src", "../public/img/base.png");
        $('#imgloadp').attr("width", "200px");
        $('#imgloadp').attr("height", "160px");
        $("#auximgp").val("");
        $("#pimg").val("");
        $("#delfot").css("display", "none");
      },
      error: function(){
        $('#imgloadp').attr("src", "../public/img/error.png");
        $('#imgloadp').attr("width", "100px");
        $('#imgloadp').attr("height", "50px");
      }
  });
}