angular.module('plunker', ['ui.bootstrap']);
var ModalDemoCtrl = function ($scope, $modal, $log) {

  $scope.open = function () {
  
    var modalInstance = $modal.open({
      templateUrl: 'myModalContent.html',
      controller: ModalInstanceCtrl
    });

    modalInstance.result.then(function (selected) {
      $scope.selected = selected;
    }, function () {
      $log.info('Modal dismissed at: ' + new Date());
    });
  };
};

var ModalInstanceCtrl = function ($scope, $modalInstance, $timeout) {

   $scope.dt = new Date();


  $scope.open = function() {
   
    $timeout(function() {
      $scope.opened = true;
    });
  };

  
  $scope.ok = function () {
    $modalInstance.close($scope.dt);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
};

