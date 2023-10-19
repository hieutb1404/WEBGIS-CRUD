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
                echo form_open_multipart('diem/edit/' . $diem->id_diem);
            ?>

            <div class="form-group">
                <label>Tên điểm</label>
                <input name="tendiem" value="<?= $diem->tendiem ?>" placeholder="Tên Điểm" type="text" class="form-control"/>
            </div>

            <div class="form-group">
                <label>Loại</label>
                <input name="loai" value="<?= $diem->loai ?>" placeholder="Loại" type="text" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Vị trí</label>
                <input name="vitri" value="<?= $diem->vitri ?>" placeholder="Vị trí" type="text" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Chữ lượng</label>
                <input name="chuluong" value="<?= $diem->chuluong ?>" placeholder="Chữ lượng" type="text" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Thời gian</label>
                <input name="thoigian" value="<?= $diem->thoigian ?>" placeholder="Thời gian" type="text" class="form-control"/>
            </div>

            <div class="form-group">
                <label>Hình ảnh</label>
                <img  src="<?= base_url('assets/hinhanh/' . $diem->hinhanh) ?>" width="120px"/>
            </div>

            <div class="form-group">
                <label>Kinh độ</label>
                <input id="kinhdo" value="<?= $diem->kinhdo ?>" name="kinhdo" placeholder="Kinh độ" type="text" class="form-control"required/>
            </div>

            <div class="form-group">
                <label>Vĩ độ</label>
                <input id="vido" value="<?= $diem->vido ?>" name="vido" placeholder="Vĩ độ" type="text" class="form-control"required/>
            </div>

            <div class="form-group">
                <label>Điểm</label>
                <select name="diem" class="form-control">
                    <opiton value="<?= $diem-> diem ?>"><?= $diem->diem ?></opiton>
                    <option value="marker2.png">Điểm 1</option>
                    <option value="marker3.png">Điểm 2</option>
                    <option value="marker4.png">Điểm 3</option>

                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-info">edit</button>
                <button type="reset" class="btn btn-success">ok</button>

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
    center: [<?= $diem->vido ?>, <?= $diem->kinhdo?>], // Tọa độ trung tâm Quảng Ninh
    zoom: 9, // Mức độ phóng to ban đầu để hiển thị vùng Quảng Ninh
    maxBounds: [
        [20.6948, 106.6288], // Tọa độ tây bắc Quảng Ninh
        [21.4317, 107.7139] // Tọa độ đông nam Quảng Ninh
    ],
    layers: [peta2] // Bạn có thể chọn lớp bản đồ khác nếu cần
});


var baseLayers = {
    "Grayscale": peta1,
    "Satellite": peta2,
    "Streets": peta3
};

var overlays = {}; // Gán giá trị là một đối tượng trống

L.control.layers(baseLayers).addTo(map);

var curLocation = [0,0];
if(curLocation[0] == 0 && curLocation[1] == 0){
    curLocation =[<?= $diem->vido ?>, <?= $diem->kinhdo?>];
}

map.attributionControl.setPrefix(false);
var marker = new L.marker(curLocation, {
    draggable: 'true',
})

marker.on('dragend', function(event){
    var position =marker.getLatLng();
    marker.setLatLng(position, {
        draggable: 'true',
    }).bindPopup(position).update();
    $('#vido').val(position.lat);
    $('#kinhdo').val(position.lng).keyup();
});

$('#vido , #kinhdo').change(function (){
    var position = [parseInt($('#vido').val()), parseInt($('#kinhdo').val())];
    marker.setLatLng(position,{
        draggable: true,
    }).bindPopup(position).update();
    map.panTo(position);
});

map.addLayer(marker);



</script>