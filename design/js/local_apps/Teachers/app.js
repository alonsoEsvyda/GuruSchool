var app = angular.module("AppTeachers", [ ]);

app.controller("DataTeacherController", function($scope,$http){
	
	var ctrl = this;

	ctrl.tab = 1; 

	//cambia el valor de tab por el parametro
	ctrl.selectTab = function(setTab){
		ctrl.tab = setTab;
	};
	//valida si tab es igual al parametro de la funcion, retorna true
	ctrl.isSelect = function(checkTab){
		return ctrl.tab === checkTab;
	}

});