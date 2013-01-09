'use strict';

/* Directives */


angular.module('myApp.directives', []).
    directive('appVersion', ['version', function (version) {
    return function (scope, elm, attrs) {
        elm.text(version);
    };
}]);


angular.module('myApp.directives').
    directive('activeLink', ['$location', function (location) {
    return function (scope, element, attrs, controller) {
        var clazz = attrs.activeLink;
        scope.location = location;
        scope.$watch('location.path()', function (newPath) {
            angular.element(element).find('a').parent().removeClass(clazz);
            angular.element(element).find('a[href="#' + newPath + '"]').parentsUntil(element, 'li').addClass(clazz);
        });
    };
}]);