angular.module("widgetkit").controller("folderCtrl", ["$scope", function(e) {}]).run(["$rootScope", "mediaInfo", function(e, r) {
    e.$on("wk.preview.content", function(e, o) {
        if ("folder" == o.type && o.data.prepared) {
            var n, t = JSON.parse(o.data.prepared);
            t.length > 0 && (n = t[0].media, e.preview = r(n).image)
        }
    })
}]);