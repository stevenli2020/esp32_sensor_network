<head>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
    <!-- <script src="../JS/markerClusterer.js"></script> -->
    <script src="../JS/map.js"></script>
</head>

<body>
    <div class="container mb-2 mt-5">
        <h2>Location of Facilites</h2>
        <input
        id="pac-input"
        class="controls form-control"
        type="text"
        placeholder="Search Box"
        />
        <div id="map"></div>
    </div>
    

    <!-- 
    The `defer` attribute causes the callback to execute after the full HTML
    document has been parsed. For non-blocking uses, avoiding race conditions,
    and consistent behavior across browsers, consider loading using Promises
    with https://www.npmjs.com/package/@googlemaps/js-api-loader.
    -->
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0sYUSro6h_goOpkpnPYRnwI70B_cY4vo&callback=initMap&v=weekly&libraries=places"
    defer
    ></script>
</body>
