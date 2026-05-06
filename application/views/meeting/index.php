<!DOCTYPE html>
<html>

<head>
    <title><?= $title; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    <style>
        body {
            background-color: #f5f6fa;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            font-weight: 600;
            background-color: #ffffff;
            border-bottom: 1px solid #eee;
        }

        label {
            font-weight: 500;
            margin-bottom: 6px;
        }

        .page-title {
            font-weight: 700;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .action-button {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .navbar-brand {
            font-weight: 700;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="<?= base_url('meeting'); ?>">Meeting Room App</a>

            <div>
                <a class="btn btn-outline-light btn-sm" href="<?= base_url('meeting'); ?>">
                    Booking
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="page-title mb-1">Management Ruang Meeting</h2>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

     <!-- TOP SECTION -->
        <div class="row mb-4">

            <!-- Cek Ruangan Yang Tersedia -->
            <div class="col-md-8 mb-4 mb-md-0">
                <div class="card h-100">
                    <div class="card-header">
                        Cek Ketersediaan Ruangan
                    </div>

                    <div class="card-body">
                        <form action="<?= base_url('meeting/check_availability'); ?>" method="GET">

                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label>Ruangan</label>
                                    <select name="room_id" class="form-control" required>
                                        <option value="">-- Pilih Ruangan --</option>
                                        <?php foreach ($rooms as $room) : ?>
                                            <option value="<?= $room->id; ?>">
                                                <?= $room->room_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" name="meeting_date" class="form-control" required>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label>Mulai</label>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label>Selesai</label>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>

                                <div class="col-md-2 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">
                                        Cek
                                    </button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- JADWAL ONGOING MEETING -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-warning-subtle">
                        Ongoing Meeting Today
                    </div>

                    <div class="card-body">

                        <?php if (!empty($ongoing_meetings)) : ?>

                            <?php foreach ($ongoing_meetings as $meeting) : ?>

                                <div class="border rounded p-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">
                                            <?= $meeting->room_name; ?>
                                        </h6>

                                        <span class="badge bg-danger">
                                            Ongoing
                                        </span>
                                    </div>

                                    <p class="mb-1 small">
                                        <strong>Booked By:</strong>
                                        <?= $meeting->booked_by; ?>
                                    </p>

                                    <p class="mb-1 small">
                                        <strong>Time:</strong>
                                        <?= $meeting->start_time; ?> - <?= $meeting->end_time; ?>
                                    </p>

                                    <p class="mb-0 small">
                                        <strong>Agenda:</strong>
                                        <?= $meeting->agenda; ?>
                                    </p>
                                </div>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <div class="text-center text-muted py-4">
                                <p class="mb-0">
                                    Tidak ada meeting yang sedang berlangsung.
                                </p>
                            </div>

                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>

        <!-- MAIN SECTION -->
        <div class="row">

            <!-- FORM -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Form Booking Meeting
                    </div>

                    <div class="card-body">
                        <form action="<?= base_url('meeting/room'); ?>" method="POST">

                            <div class="mb-3">
                                <label>Ruangan</label>
                                <select name="room_id" class="form-control" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    <?php foreach ($rooms as $room) : ?>
                                        <option value="<?= $room->id; ?>">
                                            <?= $room->room_name; ?> - Kapasitas <?= $room->capacity; ?> orang
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Booked By</label>
                                <input type="text" name="booked_by" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Tanggal Meeting</label>
                                <input type="date" name="meeting_date" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Agenda</label>
                                <textarea name="agenda" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Save Booking
                            </button>

                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        List Booking
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Filter Ruangan</label>
                                    <select id="roomFilter" class="form-control">
                                        <option value="">Semua Ruangan</option>
                                        <?php foreach ($rooms as $room) : ?>
                                            <option value="<?= $room->room_name; ?>">
                                                <?= $room->room_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <table id="bookingTable" class="table table-bordered table-striped w-100">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Room</th>
                                        <th>Booked By</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Agenda</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php if (!empty($bookings)) : ?>

                                        <?php $no = 1; ?>
                                        <?php foreach ($bookings as $booking) : ?>

                                            <tr>
                                                <td><?= $no++; ?></td>

                                                <td data-search="<?= trim($booking->room_name); ?>">
                                                    <strong><?= trim($booking->room_name); ?></strong>
                                                
                                                </td>

                                                <td><?= $booking->booked_by; ?></td>

                                                <td><?= $booking->meeting_date; ?></td>

                                                <td>
                                                    <?= $booking->start_time; ?>
                                                    -
                                                    <?= $booking->end_time; ?>
                                                </td>

                                                <td><?= $booking->agenda; ?></td>

                                                <td>
                                                    <div class="action-button">

                                                        <?php
                                                        $meeting_datetime = strtotime($booking->meeting_date . ' ' . $booking->start_time);
                                                        $now = time();
                                                        ?>

                                                        <?php if ($meeting_datetime > $now) : ?>

                                                            <a href="<?= base_url('meeting/edit/' . $booking->id); ?>"
                                                                class="btn btn-warning btn-sm">
                                                                Edit
                                                            </a>

                                                        <?php else : ?>

                                                            <button class="btn btn-secondary btn-sm" disabled>
                                                                Locked
                                                            </button>

                                                        <?php endif; ?>

                                                        <a href="<?= base_url('meeting/delete/' . $booking->id); ?>"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Delete this booking?')">
                                                            Delete
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>

                                    <?php else : ?>

                                        <tr>
                                            <td colspan="7" class="text-center">
                                                No booking data
                                            </td>
                                        </tr>

                                    <?php endif; ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#bookingTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                ordering: true
            });

            $('#roomFilter').on('change', function() {
                var selectedRoom = this.value;

                if (selectedRoom) {
                    table.column(1).search('^' + selectedRoom + '$', true, false).draw();
                } else {
                    table.column(1).search('').draw();
                }
            });
        });
    </script>

</body>

</html>