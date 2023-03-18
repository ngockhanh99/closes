app.directive('showMore', function($apply){
    return {
        restrict: 'A',
        scope: {
            text: '<ngBind',
            numberText: '=?'
        },
        link: function(scope, element){
            scope.numberText = scope.numberText || 140
            if(scope.text.length > (scope.numberText + 15)) {
                $apply(() => element.text(scope.text.substr(0, scope.numberText) + ' ....'))
            }
            element.on('click',() => element.text(scope.text))
            element.css({
                cursor: 'pointer'
            })
        }
    }
})