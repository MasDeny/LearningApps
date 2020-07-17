<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dropify.min.css" />
	<script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/dropify.min.js"></script>
</head>

<body>
	<?php $this->load->view("admin/_partials/navbar.php") ?>
	<?php $this->load->view("admin/_partials/sidebar.php") ?>
	<div class="app-main__inner">
		<div class="app-page-title">
			<div class="page-title-wrapper">
				<div class="page-title-heading">
					<div class="page-title-icon">
						<i class="pe-7s-add-user icon-gradient bg-mean-fruit">
						</i>
					</div>
					<div><?php echo $title ?>
						<div class="page-title-subheading">Menu admin untuk menambahkan pengguna aktif.
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-card mb-3 p-5 card">
			<div class="card-body">
				<form id="submit" url="<?php echo base_url() ?>" enctype="multipart/form-data">
					<h5 class="card-title">Data Pengguna</h5>
					<div class="form-row">
						<div class="col-md-5">
							<div class="position-relative form-group">
								<label class="">Email</label>
								<input name="email" placeholder="Masukkan Email" type="email" class="form-control" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label>Nama Pengguna</label>
								<input name="username" placeholder="Masukkan Nama Pengguna" type="text" class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label class="">Jenis User</label>
								<select name="role" id="role" class="form-control" required>
									<option disabled>-- Pilih Role User Yang Akan Dibuat --</option>
									<option value="guru">Guru</option>
									<option value="murid">Murid</option>
									<option value="administrator">Administrator</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="position-relative form-group">
								<label class="">Password</label>
								<input name="password" type="password" class="form-control" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="position-relative form-group">
								<label class="">Masukkan Ulang Password</label>
								<input name="password_confirm" type="password" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="data-profile">
						<div class="divider"></div>
						<h5 class="card-title">Profile Pengguna</h5>
						<div class="form-row">
							<div class="col-md-3">
								<div class="position-relative form-group">
									<label class="id">Nomor Induk Pegawai</label>
									<input name="id" type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label class="">Nama Lengkap</label>
									<input name="fullname" id="fullname" type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-3" id="position">
								<div class="position-relative form-group">
									<label class="">Posisi Di Sekolah</label>
									<input name="position" id="position" type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-3" id="class">
								<div class="position-relative form-group">
									<label class="">Kelas</label>
									<select name="class" id="class" class="form-control" required>
										<option value="1">Kelas 1</option>
										<option value="2">Kelas 2</option>
										<option value="3">Kelas 3</option>
									</select>
								</div>
							</div>
							<div class="col-md-8">
								<div class="position-relative form-group">
									<label class="">Tempat Lahir</label>
									<input name="place" id="place" type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label class="">Tanggal Lahir</label>
									<input name="date" id="date" type="text" class="form-control" data-toggle="datepicker">
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label class="">Jenis Kelamin</label>
									<select name="gender" id="gender" class="form-control" required>
										<option disabled>-- Pilih Jenis Kelamin --</option>
										<option value="Laki-Laki">Laki-Laki</option>
										<option value="Perempuan">Perempuan</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label class="">Agama</label>
									<select name="religion" id="religion" class="form-control" required>
										<option disabled>-- Pilih Agama yang dianut --</option>
										<option value="Islam">Islam</option>
										<option value="Kristen">Kristen</option>
										<option value="Katolik">Katolik</option>
										<option value="Protestan">Protestan</option>
										<option value="Hindu">Hindu</option>
										<option value="Budha">Budha</option>
										<option value="Konghucu">Konghucu</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label class="">Nomor telepon</label>
									<input name="phone" id="phone" type="number" class="form-control">
								</div>
							</div>
						</div>
						<div class="position-relative form-group">
							<label for="exampleAddress" class="">Alamat</label>
							<input name="address" id="address" type="text" class="form-control">
						</div>
						<div class="form-row">
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label class="">Kota / Kabupaten</label>
									<input name="city" id="city" type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label class="">Provinsi</label>
									<input name="state" id="state" type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-2">
								<div class="position-relative form-group">
									<label class="">Kode Pos</label>
									<input name="zip" id="zip" type="text" class="form-control">
								</div>
							</div>
						</div>
						<div class="position-relative form-group">
							<label for="exampleAddress" class="">Upload Foto Profile</label>
							<input name="file" id="file" type="file" class="form-control dropify" accept="image/*" data-max-file-size="1M" data-height="300" data-allowed-file-extensions="jpg jpeg png" data-errors-position="outside" multiple>
						</div>
					</div>
					<button class="mt-4 p-2 btn text-light btn-block bg-strong-bliss" id="registerBtn" type="submit"><h6>Simpan data</h6></button>
				</form>
			</div>
		</div>
	</div>
	<div id="toast-container" class="toast-top-right" style="margin-top:8vh">
	</div>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/register.js" hidden></script>
	<?php $this->load->view("admin/_partials/footer.php") ?>

</body>

</html>