<div class="card-body">
    <div id="map" style="width: 100%;height:730px;color:black;"></div>
</div>

<script>
    var diem = new L.markerClusterGroup();
    var duong = new L.layerGroup();
    var vung = new L.layerGroup();
    var tbl_diem = new L.markerClusterGroup();
    var tbl_duong = new L.layerGroup();;
    var tbl_vung = new L.layerGroup();;


    

    


var map = L.map('map', {
    center: [14.0583, 108.2772], // Tọa độ trung tâm của Việt Nam
    zoom: 6, // Mức độ phóng to ban đầu
    maxBounds: [
        [8.19, 102.14], // Tọa độ tây bắc (vùng biển phía Bắc)
        [23.39, 109.46] // Tọa độ đông nam (vùng biển phía Nam)
    ],
    layers: [] // Các lớp bản đồ khác (nếu có)
});

var GoogleSatelliteHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
    maxZoom: 22,
    attribution: 'WebGIS Training by trung hieu'
}).addTo(map);

var g_roadmap = new L.Google('ROADMAP');
var g_satellite = new L.Google('SATELLITE');
var terrain = new L.Google('TERRAIN');




L.control.scale({ maxWidth: 150 }).addTo(map);

var OpenStreetMap_Mapnik = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

var baseMaps = [
    {
        groupName: "Base Maps",
        expanded: true,
        layers: {
            " Lớp vệ tinh": GoogleSatelliteHybrid,
            " Lớp bản đồ": OpenStreetMap_Mapnik,
            " Google Satellite": g_satellite,
            " Road map": g_roadmap,
            " Terrain": terrain,
        }
    }
];
var overlays = [
    {
        groupName: 'Pete Dasar',
        expanded: true,
        layers: { 
            ' Điểm': diem, 
            ' Đường': duong,
            ' Vùng': vung 
        }
    },{
     groupName: "Bùi Trung Hiếu GIS",
    expanded: true,
    layers: {
        "Điểm thật": tbl_diem,
        "Đường thật": tbl_duong,
        "Vùng thật": tbl_vung,
}

}
];
var options = {
    container_width: "300px",
    group_maxHeight: "80px",
    exclusive: false,
    collapse: true,
    position: 'topright',
};

var control = L.Control.styledLayerControl(baseMaps, overlays, options);
map.addControl(control);

// duong chi dan duong di
L.Routing.control({
    routeWhileDragging: true,
    geocoder: L.Control.Geocoder.nominatim(),
}).addTo(map);

L.Control.geocoder().addTo(map);


// Lấy dữ liệu điểm từ tệp geojson/diem.php
$.getJSON("<?=base_url()?>assets/geojson/diem.php", function (data) {
    var ratIcon = L.icon({
        iconUrl: '<?=base_url()?>assets/marker.png',
        iconSize: [60, 50],
    });
    
    // Tạo các marker và thêm vào layerGroup "diem"
    L.geoJson(data,{
        pointToLayer: function (feature, latlng) {
            var marker = L.marker(latlng,{icon: ratIcon});
            marker.bindPopup("<table class='table table-striped table-bordered table-condensed'>" 
            + "<tr><th>Mã</th><td>" 
            + feature.properties.id_diem 
            + "</td></tr>" 
            + "<tr><th>Tên điểm khoáng sản</th><td>" 
            + feature.properties.tendiem 
            + "</td></tr>"
            + "<tr><th>Vị trí</th><td>" 
            + feature.properties.vitri 
            + "</td></tr>"  
            + "<tr><th>Loại khoáng sản</th><td>" 
            + feature.properties.loai 
            + "</td></tr>" 
            + "<tr><th>Chữ lượng</th><td>" 
            + feature.properties.chuluong 
            + "</td></tr>" 
            + "<tr><th>Thời gian khai thác</th><td>" 
            + feature.properties.thoigian 
            + "</td></tr>"
            + "<tr><th>Kinh độ</th><td>" 
            + feature.properties.kinhdo 
            + "</td></tr>"  
            + "<tr><th>Vĩ độ</th><td>" 
            + feature.properties.vido 
            + "</td></tr>" 
            + "</table>");
            return marker;
        }
    }).addTo(diem);
});

// Lấy dữ liệu điểm từ tệp geojson/duong.php
$.getJSON("<?=base_url()?>assets/geojson/duong.php", function (data) {
    // Tạo các marker và thêm vào layerGroup "duong"
    L.geoJson(data, {
        style: function (feature) {
            var color = feature.properties.color;
            return { color: "#0000FF", weight: 2, fillColor: color, fillOpacity: 0.6 };
        },
        onEachFeature: function (feature, layer) {
            layer.bindPopup("<table class='table table-striped table-bordered table-condensed'>" +
                "<tr><th>Mã</th><td>" + feature.properties.objectid + "</td></tr>" +
                "<tr><th>Tên đường</th><td>" + feature.properties.tenduong + "</td></tr>" +
                "<tr><th>kiểu đường</th><td>" + feature.properties.kieuduong + "</td></tr>" +
                "<tr><th>Chiều dài</th><td>" + feature.properties.chieudai + "</td></tr>" +
                "<tr><th>Màu đường</th><td>" + feature.properties.color + "</td></tr>" +
                "</table>");
            layer.on('mouseover', function (e) {
                this.setStyle({
                    weight: 2,
                    color: 'cyan',
                    dashArray: '',
                    fillOpacity: 0.8
                });
                if (!L.Browser.ie && !L.Browser.opera) {
                    layer.bringToFront();
                }
                info.update(layer.feature.properties);
            });
            layer.on('mouseout', function (e) {
                this.setStyle({
                    weight: 2,
                    color: feature.properties.color,
                    dashArray: '',
                    fillOpacity: 0.6
                });
            });
        }
    }).addTo(duong);
});

// Lấy dữ liệu điểm từ tệp geojson/vung.php
$.getJSON("<?=base_url()?>assets/geojson/vung.php", function (data) {
    // Tạo các marker và thêm vào layerGroup "vung"
    L.geoJson(data, {
        style: function (feature) {
            var color = feature.properties.color;
            return { color: "#999", weight: 2, fillColor: color, fillOpacity: .6 };
        },
        onEachFeature: function (feature, layer) {
            layer.bindPopup("<table class='table table-striped table-bordered table-condensed'>" +
                "<tr><th>Tên tỉnh</th><td>" + feature.properties.tentinh + "</td></tr>" +
                "<tr><th>Đơn vị hành chính</th><td>" + feature.properties.donvihanhc + "</td></tr>" +
                "<tr><th>Diện tích</th><td>" + feature.properties.dientich + "</td></tr>" +
                "<tr><th>Tên vùng</th><td>" + feature.properties.tenvung + "</td></tr>" +
                "<tr><th>Màu vùng</th><td>" + feature.properties.color + "</td></tr>" +
                "</table>");
            layer.on('mouseover', function (e) {
                this.setStyle({
                    weight: 2,
                    color: 'cyan',
                    dashArray: '',
                    fillOpacity: 0.8
                });
                if (!L.Browser.ie && !L.Browser.opera) {
                    layer.bringToFront();
                }
                info.update(layer.feature.properties);
            });
            layer.on('mouseout', function (e) {
                this.setStyle({
                    weight: 2,
                    color: feature.properties.color,
                    dashArray: '',
                    fillOpacity: 0.6
                });
            });
        }
    }).addTo(vung);

});


<?php foreach($diem as $key => $value) { ?>
    var marker = L.marker([<?= $value->vido ?>, <?= $value->kinhdo ?>], {
        icon: L.icon({
            iconUrl: '<?= base_url('assets/' . $value->diem) ?>',
            iconSize: [30, 36],
        })
    }).addTo(tbl_diem).bindPopup(
        "<table class='table table-striped table-bordered table-condensed'>" +
        "<tr><th>Mã</th><td><?= $value->id_diem ?></td></tr>" +
        "<tr><th>Tên điểm khoáng sản</th><td><?= $value->tendiem ?></td></tr>" +
        "<tr><th>Vị trí</th><td><?= $value->vitri ?></td></tr>" +
        "<tr><th>Loại khoáng sản</th><td><?= $value->loai ?></td></tr>" +
        "<tr><th>Chữ lượng</th><td><?= $value->chuluong ?></td></tr>" +
        "<tr><th>Thời gian khai thác</th><td><?= $value->thoigian ?></td></tr>" +
        "<tr><th>Hình ảnh</th><td>" +
        "<img src='<?= base_url('assets/hinhanh/' . $value->hinhanh) ?>' width='180px'/>" +
        "<tr><th>Kinh độ</th><td><?= $value->kinhdo ?></td></tr>" +
        "<tr><th>Vĩ độ</th><td><?= $value->vido ?></td></tr>" +
        "</table>"
    );
<?php } ?>

<?php foreach($duong as $key => $value) { ?>
    var duonglayer = L.geoJSON(<?= $value->geojson; ?>, {
        style: {
            color: "<?= $value->color ?>"
        },
    }).addTo(tbl_duong);
    duonglayer.eachLayer(function(layer) {
            layer.bindPopup(
                "<table class='table table-striped table-bordered table-condensed'>" +
                "<tr><th>Mã</th><td><?= $value->id_duong ?></td></tr>" +
                "<tr><th>Tên đường</th><td><?= $value->tenduong ?></td></tr>" +
                "<tr><th>Kiểu đường</th><td><?= $value->kieuduong ?></td></tr>" +
                "<tr><th>Màu</th><td><?= $value->color ?></td></tr>" +
                "<tr><th>Hình ảnh</th><td>" +
                "<img src='<?= base_url('assets/hinhanh/' . $value->hinhanh) ?>' width='180px'/>" +
                "</table>"
            );

        })
<?php } ?>


<?php foreach($vung as $key => $value) { ?>
    var vunglayer = L.geoJSON(<?= $value->geojson; ?>, {
        style: {
            color: 'white',
            dashArray: '3',
            lineCap: 'butt',
            lineJoin: 'miter',
            fillColor: '<?= $value->color; ?>',
            fillOpacity: 1.0,
        },
     
    }).addTo(tbl_vung);
    vunglayer.eachLayer(function(layer) {
        layer.bindPopup(
            "<table class='table table-striped table-bordered table-condensed'>" +
            "<tr><th>Mã</th><td><?= $value->id_vung ?></td></tr>" +
            "<tr><th>Tên vùng</th><td><?= $value->tenvung ?></td></tr>" +
            "<tr><th>Tên tỉnh</th><td><?= $value->tentinh ?></td></tr>" +
            "<tr><th>Đơn vị hành chính</th><td><?= $value->donvihanhchinh ?></td></tr>" +
            "<tr><th>Diện tích</th><td><?= $value->dientich ?></td></tr>" +
            "<tr><th>Màu</th><td><?= $value->color ?></td></tr>" +
            "<tr><th>Hình ảnh</th><td>" +
            "<img src='<?= base_url('assets/hinhanh/' . $value->hinhanh) ?>' width='180px'/>" +
            "</table>"
        );
    });
<?php } ?>







    
</script>

<!-- 
    lefletjs
    Hiển thị Bản Đồ Tương Tác: Leaflet cho phép bạn hiển thị bản đồ trên trang web của bạn và tương tác với nó. Bạn có thể thêm các lớp bản đồ, đánh dấu, đường đi và nhiều tính năng khác.
    Hiển Thị Dữ Liệu Địa Lý: Bạn có thể sử dụng Leaflet để hiển thị dữ liệu địa lý, chẳng hạn như vị trí của các địa điểm quan trọng, biên giới hành chính, hoặc dữ liệu khoa học địa lý.

Tạo Ứng Dụng Thời Tiết: Leaflet thường được sử dụng để tạo ứng dụng thời tiết, cho phép người dùng xem dự báo thời tiết trên bản đồ.

Phân Tích Dữ Liệu Địa Lý: Bạn có thể sử dụng Leaflet để thực hiện phân tích dữ liệu địa lý, chẳng hạn như tìm kiếm địa điểm gần nhất, tính toán khoảng cách giữa các điểm, và nhiều tác vụ khác.

Tạo Ứng Dụng Hướng Dẫn Đường: Leaflet có thể được sử dụng để tạo ứng dụ
 -->