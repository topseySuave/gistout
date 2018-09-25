/**
 * Created by Daniel on 7/1/2017.
 */

app.directive('onFinishRender', ['$timeout', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit(attr.onFinishRender);
                });
            }
        }
    }
}]);
app.directive('gistAuthorLoaded', ['$timeout', function ($timeout) {
    return {
        link: function ($scope, element, attrs) {
            $scope.$on('contentLoaded', function () {
                $timeout(function () {
                    init();
                    $('.modal').modal();
                }, 0, false);
            })
        }
    };
}]);
app.directive('onContentRender', ['$timeout', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$render === true) {
                $timeout(function () {
                    scope.$emit(attr.onContentRender);
                });
            }
        }
    }
}]);
app.directive('onKeyEnter', function () {
    return function (scope, elem, attrs) {
        elem.bind('keydown keypress', function (e) {
            if(e.which === 13){
                scope.$apply(function(){
                    scope.$eval(attrs.onKeyEnter);
                });
                e.preventDefault();
            }
        });
    }
});
app.directive('goAuthenticate', function () {
    return function (scope, elem, attr) {
        elem.on('click', function (e) {
            scope.$apply(function () {
                scope.$eval(attr.goAuthenticate);
            });
            e.preventDefault();
        })
    }
});