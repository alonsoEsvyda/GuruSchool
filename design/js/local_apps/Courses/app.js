var app = angular.module("AppCourses", [ ]);

app.controller("ListCourses", function($scope,$http){
	
	var ctrl = this;

	ctrl.courses_get = {};
	ctrl.quantity = 0;
	ctrl.subcategorie = "Cursos";
	ctrl.loading = {
		"all":true
	}

	$http.post(Hostname()+"/GuruSchool/cursos/ApilistCourses/")
			.success(function(data){
				ctrl.courses_get = data;
				ctrl.pagination = true;
				ctrl.loading.all = false;
			}).error(function(error){
				console.log(error);
				ctrl.pagination = false;
			});

	ctrl.CoursesFilter = function(item){
		ctrl.loading.all = true;
    	var filter_data = item.currentTarget.getAttribute("data-name");
    	$http.post(Hostname()+"/GuruSchool/cursos/ApiSearchCourses/",{"filter":filter_data,"quantity":ctrl.quantity})
			.success(function(data){
				ctrl.subcategorie = filter_data;
				ctrl.courses_get = data;
				ctrl.quantity = 0;
				ctrl.loading.all = false;
			}).error(function(error){
				console.log(error);
			});
	}
	ctrl.Pagination = function(value){
		ctrl.loading.all = true;
		var value = parseFloat(value) + parseFloat(ctrl.quantity);
		ctrl.quantity = value;
		$http.post(Hostname()+"/GuruSchool/cursos/ApiSearchCourses/",{"quantity":ctrl.quantity,"filter":ctrl.subcategorie})
			.success(function(data){
				ctrl.courses_get = data;
				ctrl.loading.all = false;
			}).error(function(error){
				console.log(error);
			});
	}

	ctrl.replaceFunction = function(item,target,replace){
		return item.split(target).join(replace);
	}

});