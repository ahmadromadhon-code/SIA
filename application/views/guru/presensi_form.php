<h3>Input Presensi untuk Kelas: <?= $jadwal->kelas_id ?></h3>
<p>Pertemuan ke: <?= $pertemuan ?></p>

<?= form_open('guru/simpan_presensi'); ?>
    <input type="hidden" name="jadwal_id" value="<?= $jadwal->id; ?>">
    <input type="hidden" name="pertemuan" value="<?= $pertemuan; ?>">
    <input type="hidden" name="semester" value="<?= $jadwal->semester; ?>">
    
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($siswa as $key => $s): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $s->nis ?></td>
                <td><?= $s->nama ?></td>
                <td>
                    <input type="hidden" name="siswa_id[]" value="<?= $s->id; ?>">
                    <select name="keterangan[]" required>
                        <option value="hadir">Hadir</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="alfa">Alfa</option>
                    </select>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <button type="submit">Simpan Presensi</button>
<?= form_close(); ?>