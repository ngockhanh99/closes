app.directive('formatInputNumber', function(){
    return {
        restrict: 'A',
        link: function(scope, element, attrs){
            element.on('keyup', function(){
                let value = +element.val().replace(/\D/g,'')
                element.val(value.toLocaleString('en-US'))
            })
            element.on('focus', function(){
                let value = +element.val().replace(/\D/g,'')
                element.val(value.toLocaleString('en-US'))
            })
        }
    }
})