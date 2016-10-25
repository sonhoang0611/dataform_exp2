'use strict';
var app = angular.module('mainApp', ['ngRoute']);
app.config(function($routeProvider) {
        $routeProvider
            // route for the about page
            .when('/flightdetails', {
                templateUrl : 'flightdetails.html'

            })

             .when('/availableflights', {
                templateUrl : 'flightdetails.html'

            })

            .when('/guestInfo', {
                templateUrl : 'guestInfo.html'
            })

            .when('/passengers', {
                templateUrl : 'passenger.html'
            })

            // route for the contact page
            .when('/availableflights', {
                templateUrl : 'findFlight.html'
            })
    });

$(document).ready(function() {
    $.ajax({
        type: 'GET',
        url: "http://localhost/FlightApp/v1/departureFlights",
        dataType: 'json', // Notice! JSONP <-- P (lowercase)
        success: function(data) {

           
            $.each(data.departureFlights, function(index) {
                $('#departureFlights').append("<option value='" + data.departureFlights[index].airplanename + " - " + data.departureFlights[index].airplanecode + "\'>");
            });

        },
        error: function() {
            alert("Error");
        }
    });


    $('#departFlights').on('blur', function() {
        var string = $(this).val().split(" ");
        var code = string[string.length - 1];
        $.ajax({
            type: 'GET',
            url: "http://localhost/FlightApp/v1/destinationFlights/" + code,
            dataType: 'json', // Notice! JSONP <-- P (lowercase)
            success: function(data) {

                
                $("#destinationFlights").html("");
                $.each(data.desFlights, function(index) {
                    $('#destinationFlights').append("<option value='" + data.desFlights[index].airplanename + " - " + data.desFlights[index].destination + "\'>");
                });

            },
            error: function() {
                alert("You haven't fill departure");
            }
        });
    });

    $('#searchFlight').on('click', function() {
        var string1 = $("#departFlights").val().split(" ");
        var code1 = string1[string1.length - 1];
        var string2 = $("#desFlight").val().split(" ");
        var code2 = string2[string2.length - 1];
        $.ajax({
            type: 'GET',
            url: "http://localhost/FlightApp/v1/flights/" + code1 + "/" + code2 + "/" + $("#departDay").val() + "/" + $("#quantity option:selected").text(),
            dataType: 'json', // Notice! JSONP <-- P (lowercase)
            success: function(data) {
                $('#tableFindFlight').html("").append("<tr><th>Date<\/th><th>FlightCode<\/th><th>Departure<\/th><th><\/th><th>Destination<\/th><th>Class<\/th><th>PriceTag<\/th><th>PriceTicket<\/th><th>Action<\/th><\/tr>");
                $.each(data.availableFlights, function(index){
                   
                     $('#tableFindFlight').append("<tr class='flight" + index + "'><td>" + data.availableFlights[index].departday + "<\/td><td>"  + data.availableFlights[index].flightcode + "<\/td><td>"  + data.availableFlights[index].departure + "<\/td><td><i class='fa fa-long-arrow-right fa-4x'><\/i><\/td><td>" + data.availableFlights[index].destination + "<\/td><td>"  + data.availableFlights[index].class + "<\/td><td>" + data.availableFlights[index].pricetag + "<\/td><td>"  + data.availableFlights[index].priceticket + "<\/td><td><input type='button' class='selectFlight' value='Select'><\/td><\/tr>");
                });

            },
            error: function() {
                alert("fail");
            }
        });
    });

  /*   $('body').on('click',"tr[class^='flight'] td input", function() {
        var className = $(this).closest('tr').attr('class');
        var flightcode = $("tr[class=" + className + "] td:nth-child(2)").text();
        alert(flightcode);
        data
        $.ajax({
            type: 'POST',
            url: "http://localhost/FlightApp/v1/flightdetails",
           dataType: 'json', // Notice! JSONP <-- P (lowercase)
            success: function(data) {
              alert("check new flight details");
            },
            error: function() {
                alert("fail");
            }
        });
    });*/

    $('input:radio[name="flightType"]').on("change",
        function() {
            if ($(this).is(':checked') && $(this).val() == 'One way') {
                $("#returnDay").addClass('hideElement');
            } else {
                $("#returnDay").removeClass('hideElement');
            }
        });
});



/*app.controller('mainCtrl', function($scope) {
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
*/