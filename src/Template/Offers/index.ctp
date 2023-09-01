<table id="offersTable" class="table table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th>Requirements</th>
        <th>Description</th>
        <th>ECPC</th>
        <th>Click URL</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($offers as $offer): ?>
        <tr>
            <td><?= h($offer['name']) ?></td>
            <td><?= h($offer['requirements']) ?></td>
            <td><?= h($offer['description']) ?></td>
            <td><?= h($offer['ecpc']) ?></td>
            <td><a href="<?= h($offer['click_url']) ?>" target="_blank">Link</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        let table = $('#offersTable').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [0,1,2,4] }
            ]
        });

        let names = <?= json_encode(array_column($offers, 'name')) ?>;

        $("#offersTable_filter input[type='search']")
            .autocomplete({
            source: names
        });
    });
</script>
