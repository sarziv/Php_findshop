<html>
<?php
//Production

//$address = $_SERVER['REMOTE_ADDR'];
//Static ip for dummy data
$address = "85.206.115.36";
$api = 'http://ip-api.com/json/'.$address;
$data = file_get_contents($api);
$data = json_decode($data,true);

//json file with shop data
$listfile = file_get_contents('list.json');
$shops = json_decode($listfile,true);

?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<head>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans|Slabo+27px" rel="stylesheet">
    <title>Shop Find module</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        .listgrColor {
            color: black;
        }
        .jumbotron {
            margin-bottom: 0px;
            background-image: url(708746.jpg);
            background-position: 0% 25%;
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            text-shadow: black 0.3em 0.3em 0.3em;
        }
        #map {
            height: 300px;
        }
        #map1 {
            height: 400px;
        }
        html, body {
            font-family: 'IBM Plex Sans', sans-serif;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5L50bnueFbAeFXMa8lKAeqEr1YQTVaz0 "></script>
    <script>
        var locations = [
            <?php foreach ($shops as $shop) {
             if($data['city'] == $shop['city']) {
                echo '[' . $shop['lat'] . ',' . $shop['lon'] . '],';
            }
        }
            //if no shop return my location
            if($data['city'] != $shop['city']) {echo '[' . $data['lat'] . ',' . $data['lon'] . '],';}
            ?>
        ];


        function initialize() {

            //maps details
            var latlng = new google.maps.LatLng(<?php echo $data['lat'] ?>,<?php echo $data['lon'] ?>);
            var latlng2 = new google.maps.LatLng(<?php echo $data['lat'] ?>,<?php echo $data['lon'] ?>);

            //draw map left user
            var myOptions = {
                zoom: 11,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //draw map right module
            var myOptions2 =  {
                zoom: 12,
                center: latlng2,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };


            var map = new google.maps.Map(document.getElementById("map"), myOptions);
            var map2 = new google.maps.Map(document.getElementById("map1"), myOptions2);

            //map user
            var myMarker = new google.maps.Marker(
                {
                    position: latlng,
                    map: map,
                });

            var count;
            //map module marking
            for (count = 0; count < locations.length; count++) {
                var myMarker2 = new google.maps.Marker(
                    {
                        position: new google.maps.LatLng(locations[count][0], locations[count][1]),
                        map: map2,
                    });
            }
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>

<div class="container-fluid text-center" >
    <div class="jumbotron">
        <h1>Shop Finder Module</h1>
        <p>Find user closet shop in City/Country and mark then on the map </p>
        <p>Free API for location  -> ip-api.com</p>
        <P>This have small sample of dummy data so ip set static.</P>
        <p>Get list of shops from root/list.json API alternative <a href="list.json">List</a></p>
        <p>API User Data -> Application <- API Shop Data</p>
        <p><a href="https://github.com/sarziv/Php_findshop">Open Project on </a><i class="fab fa-github"></i></p>
    </div>
</div>
<div class="container">
    <div class="row">
        <ul class="list-group col-sm-4">
            <h4 class="text-center">User data:</h4>
            <li class="list-group-item list-group-item-secondary listgrColor">City: <?php echo $data['city'] ?> </li>
            <li class="list-group-item list-group-item-secondary listgrColor">Country: <?php echo $data['country'] ?></li>
            <li class="list-group-item list-group-item-secondary listgrColor">Country Code: <?php echo $data['countryCode'] ?></li>
            <li class="list-group-item list-group-item-secondary listgrColor">Latitude: <?php echo $data['lat'] ?></li>
            <li class="list-group-item list-group-item-secondary listgrColor">Longitude: <?php echo $data['lon'] ?></li>
            <div id="map"></div>
        </ul>
        <div class="col-sm-8 text-center">
            <h4>Module output:</h4>
            <div id="map1"></div>
            <div class="col-sm-4">
                <br>
            </div>
        </div>
    </div>
</div>

</html>