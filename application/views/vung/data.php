<div class="card-body">
    <table class="table table-bordered text-sm" id="example1">
        <thead class="text-center">
            <tr>
                <th>Mã</th>
                <th>Tên vùng</th>
                <th>Tên tỉnh</th>
                <th>Đơn vị hành chính</th>
                <th>Màu</th>
                <th>Diện tích</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $id = 1;
            foreach ($vung as $key => $value) { ?>
            <tr>
                <td><?= $id++ ?></td>
                <td><?= $value->tenvung ?></td>
                <td><?= $value->tentinh ?></td>
                <td><?= $value->donvihanhchinh ?></td>
                <td><?= $value->color ?></td>
                <td><?= $value->dientich ?></td>
                <td><img src="<?= base_url('assets/hinhanh/' . $value->hinhanh) ?>" width="100px" alt="Lỗi"/></td>
                <td class="text-center">
                    <a href="<?= base_url('vung/edit/' . $value->id_vung) ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= base_url('vung/delete/' . $value->id_vung) ?>" class="btn btn-sm btn-danger" onclick="return confirm('canh bao')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="<?= base_url('vung/add') ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i>
                    </a>
                </td>
            </tr>
            <?php } 
            var_dump(base_url('assets/hinhanh/' . $value->hinhanh));
            ?>
        </tbody>
    </table>
</div>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive" : true,
            "autoWidth" : false,
        });
        $("#example2").DataTable({
            "paging": true,
            "lengthChange" : false,
            "searching": false,
            "ordering":  true,
            "info": true,
            "responsive" : true,
            "autoWidth" : false,
        })
    })
</script>