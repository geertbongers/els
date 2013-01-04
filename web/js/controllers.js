'use strict';

/* Controllers */

function MenuController($scope, $location) {
    $scope.changeLocation = function (path) {
        $location.path(path);
    }
}
MenuController.$inject = ['$scope', '$location'];

function MyCtrl1() {
}
MyCtrl1.$inject = [];


function MyCtrl2() {
}
MyCtrl2.$inject = [];

function DashboardController($scope) {
    $scope.messageTitle = '';
    $scope.messages = [
        {
            type:'success',
            shortTitle:'Verhuurd',
            title:'Smaragdhof veruurd',
            time:'5 min. geleden'
        }
    ]

    $scope.addMessage = function (shortTitle) {
        var type = 'success';
        if (shortTitle == 'Verhuurd') {

        } else if (shortTitle == 'Toegevoegd') {
            type = 'info';
        } else if (shortTitle == 'Gevonden') {
            type = 'warning';
        }
        $scope.messages.push(
            {
                type:type,
                shortTitle:shortTitle,
                title:$scope.messageTitle,
                time:'gisteren'
            }
        );
        $scope.messageTitle = '';
    }
}
DashboardController.$inject = ['$scope'];
