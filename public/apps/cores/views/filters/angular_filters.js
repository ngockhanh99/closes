var filterApp = angular.module('myApp')

filterApp.filter('formatDateTime',() => {
    return item => {
        if(!item) return null
        return (new Date(item)).toLocaleString('en-GB')
    }
})

filterApp.filter('formatNumber',() => {
    return item => {
        if(!item) return 0
        return item.toLocaleString('en-US')
    }
})
