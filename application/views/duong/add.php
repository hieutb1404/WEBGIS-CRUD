<div class="card-body">
    <div class="row">
        <div class="col-sm-7">
            <div id="map" style="width: 100%; height: 600px;"></div>
        </div>

        <div class="col-sm-5">
            <?php 
                echo validation_errors('<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>, 
                </div>');
                if(isset($error_upload)) {
                    echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $error_upload . '</div>';

                }
                echo form_open_multipart('duong/add');
            ?>

            <div class="form-group">
                <label>Tên đường</label>
                <input name="tenduong" placeholder="Tên Đường" type="text" class="form-control"/>
            </div>

            <div class="form-group">
                <label>GeoJSON</label>
                <textarea name="geojson" rows="4" class="form-control"></textarea>
            </div>


            <div class="form-group">
                <label>Kiểu đường</label>
                <input name="kieuduong" placeholder="Kiểu đường" type="text" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Màu</label>
                <div class="input-group my-colorpicker2">
                    <input name="color" type="text" class="form-control"/>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Hình ảnh</label>
                <input name="hinhanh" type="file" class="form-control" required/>
            </div>

            <div>
                <button type="submit" class="btn btn-info">Add</button>
                <button type="reset" class="btn btn-success">reset</button>

            </div>

            <?php 
                echo form_close();
            ?>
        </div>
    </div>
</div>

<script>
var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        'Imagery &copy; <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11'
});

var peta2 = L.tileLayer('http://www.google.com/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
    attribution: 'google'
});

var peta3 = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});


var map = L.map('map', {
    center: [21.0285, 107.2439], // Tọa độ trung tâm Quảng Ninh
    zoom: 9, // Mức độ phóng to ban đầu để hiển thị vùng Quảng Ninh
    maxBounds: [
        [20.6948, 106.6288], // Tọa độ tây bắc Quảng Ninh
        [21.4317, 107.7139] // Tọa độ đông nam Quảng Ninh
    ],
    layers: [peta3] // Bạn có thể chọn lớp bản đồ khác nếu cần
});


var baseLayers = {
    "Grayscale": peta1,
    "Satellite": peta2,
    "Streets": peta3
};

var overlays = {}; // Gán giá trị là một đối tượng trống

L.control.layers(baseLayers).addTo(map);

var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);
var drawControl = new L.Control.Draw({
    draw: {
        polygon: false,
        marker: false,
        circle: false,
        circlemarker: false,
        rectangle: false,
        polyline: true,
    },
    edit: {
        featureGroup: drawnItems
    }
});
map.addControl(drawControl);

// vẽ
map.on('draw:created',function(event){
    var layer = event.layer;
    var feature = layer.feature = layer.feature || {};
    feature.type = feature.type || "Feature";
    var props = feature.properties = feature.properties || {};
    drawnItems.addLayer(layer);
    $("[name=geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));

});

// sửa vẽ 
map.on('draw:edited',function(e){
    $("[name=geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));

});

// xóa vẽ 
map.on('draw:deleted',function(e){
    $("[name=geojson]").html(JSON.stringify(drawnItems.toGeoJSON()));

});


</script>

<script>
    $(function(){
        $('.my-colorpicker2').colorpicker()
        $('.my-colorpicker2').on('colorpickerChange', function(event){
            var newColor = event.color.toString();
    // Cập nhật màu sắc của đường vẽ
    drawnItems.setStyle({ color: newColor });
        });
    })


</script>