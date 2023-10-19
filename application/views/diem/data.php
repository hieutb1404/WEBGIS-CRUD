<div class="card-body">
    <table class="table table-bordered text-sm" id="example1">
        <thead class="text-center">
            <tr>
                <th>Mã</th>
                <th>Tên điểm</th>
                <th>Loại</th>
                <th>Vị trí</th>
                <th>Chữ lượng</th>
                <th>Thời gian</th>
                <th>Hình ảnh</th>
                <th>Kinh độ</th>
                <th>Vĩ độ</th>
                <th>Điểm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $id = 1;
            foreach ($diem as $key => $value) { ?>
            <tr>
                <td><?= $id++ ?></td>
                <td><?= $value->tendiem ?></td>
                <td><?= $value->loai ?></td>
                <td><?= $value->vitri ?></td>
                <td><?= $value->chuluong ?></td>
                <td><?= $value->thoigian ?></td>
                <td><img src="<?= base_url('assets/hinhanh/' . $value->hinhanh) ?>" width="100px" alt="Lỗi"/></td>
                <td><?= $value->kinhdo ?></td>
                <td><?= $value->vido ?></td>
                <td><?= $value->diem ?></td>

                <td class="text-center">
                    <a href="<?= base_url('diem/edit/' . $value->id_diem) ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= base_url('diem/delete/' . $value->id_diem) ?>" class="btn btn-sm btn-danger" onclick="return confirm('canh bao')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="<?= base_url('diem/add') ?>" class="btn btn-sm btn-success">
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