$(document).ready(function() {
    $("#departureFlights").on('click', function(e) {
        $.getJSON('http://localhost/FlightApp/v1/departureFlights', function(data) {
            $.each(data, function(index) {
                alert("Hala Madrid");
            });
        });
        e.preventDefault();
    });
    $('input:radio[name="flightType"]').on("change",
        function() {
            if ($(this).is(':checked') && $(this).val() == 'One way') {
                $("#returnDay").addClass('hideElement');
            } else {
                $("#returnDay").removeClass('hideElement');
            }
        });
});

var app = angular.module('mainApp', []);

app.controller('mainCtrl', function($scope) {
    $scope.places = [{
        icon: 'images/Hochiminh.jpg',
        name: 'HCM, Vietnam',
        description: 'Roma (tiếng Ý: Roma; tiếng Latinh: Rōma; còn gọi Rôma hay La Mã trong tiếng Việt) là thủ đô của nước Ý.',
        price: '199'
    }, {
        icon: 'images/Madrid.jpg',
        name: 'Madrid, Spain',
        description: 'Roma (tiếng Ý: Roma; tiếng Latinh: Rōma; còn gọi Rôma hay La Mã trong tiếng Việt) là thủ đô của nước Ý.',
        price: '199'
    }, {
        icon: 'images/Paris.jpg',
        name: 'Paris, France',
        description: 'Roma (tiếng Ý: Roma; tiếng Latinh: Rōma; còn gọi Rôma hay La Mã trong tiếng Việt) là thủ đô của nước Ý.',
        price: '199'
    }, {
        icon: 'images/London.jpg',
        name: 'London, England',
        description: 'Roma (tiếng Ý: Roma; tiếng Latinh: Rōma; còn gọi Rôma hay La Mã trong tiếng Việt) là thủ đô của nước Ý.',
        price: '199'
    }, {
        icon: 'images/Roma.jpg',
        name: 'Roma, Italia',
        description: 'Roma (tiếng Ý: Roma; tiếng Latinh: Rōma; còn gọi Rôma hay La Mã trong tiếng Việt) là thủ đô của nước Ý.',
        price: '199'
    }, {
        icon: 'images/Tokyo.jpg',
        name: 'Tokyo, Japan',
        description: 'Roma (tiếng Ý: Roma; tiếng Latinh: Rōma; còn gọi Rôma hay La Mã trong tiếng Việt) là thủ đô của nước Ý.',
        price: '199'
    }];
});

var app2 = angular.module('mainApp2', []);

app2.controller('mainCtrl2', function($scope) {
    $scope.customers = [{
        avatar: 'images/son.jpg',
        name: 'Hoang Thai Son',
        review: 'Good service. The staff are always nice and help me all the time.'
    }, {
        avatar: 'images/Kaka.jpg',
        name: 'Ricardo Kaka',
        review: 'The seats are comfortable and the meals are very delicious.'
    }, {
        avatar: 'images/quynh.jpg',
        name: 'Nguyen Van Quynh',
        review: 'Flight on time and safe. The drinks are tasty and well prepared.'
    }];
});

angular.element(document).ready(function() { angular.bootstrap(document.getElementById("review"), ['mainApp2']); });
