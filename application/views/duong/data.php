<div class="card-body">
    <table class="table table-bordered text-sm" id="example1">
        <thead class="text-center">
            <tr>
                <th>Mã</th>
                <th>Tên đường</th>
                <th>Kiểu đường</th>
                <th>Màu</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $id = 1;
            foreach ($duong as $key => $value) { ?>
            <tr>
                <td><?= $id++ ?></td>
                <td><?= $value->tenduong ?></td>
                <td><?= $value->kieuduong ?></td>
                <td><?= $value->color ?></td>
                <td><img src="<?= base_url('assets/hinhanh/' . $value->hinhanh) ?>" width="100px" alt="Lỗi"/></td>
                <td class="text-center">
                    <a href="<?= base_url('duong/edit/' . $value->id_duong) ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= base_url('duong/delete/' . $value->id_duong) ?>" class="btn btn-sm btn-danger" onclick="return confirm('canh bao')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="<?= base_url('duong/add') ?>" class="btn btn-sm btn-success">
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